<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStoreRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Repository\Interface\StoreRepositoryInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\Response;

class StoreController extends Controller
{
    use ApiResponse;

    private $storeRepo;

    /**
     * Constructor of class
     * 
     * @return void
     */
    public function __construct(StoreRepositoryInterface $storeRepo)
    {
        $this->storeRepo = $storeRepo;
    }

    /**
     * Get all list store
     * 
     * @param SearchRequest $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function list(SearchRequest $request)
    {
        try {
            $storeList = $this->storeRepo->getList($request);

            return $this->successReponse($storeList);
        } catch (\Exception $exception) {

            return $this->errorResponse($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * Create store
     * 
     * @param CreateStoreRequest $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function create(CreateStoreRequest $request)
    {
        try {
            $userId = auth('api')->user()->id;
            $data = [
                'name' => $request->name,
                'address' => $request->address,
                'user_id' => $userId
            ];
            $userCreated = $this->storeRepo->create($data);

            return $this->successReponse($userCreated);
        } catch (\Exception $exception) {

            return $this->errorResponse($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Update store
     * 
     * @param UpdateStoreRequest $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(UpdateStoreRequest $request)
    {
        try {
            $userId = auth('api')->user()->id;
            $data = [
                'name' => $request->name,
                'address' => $request->address,
                'user_id' => $userId
            ];
            $storeUpdated = $this->storeRepo->update(request()->route('id'), $data);
            if(!$storeUpdated) {
                return $this->errorResponse('Store not exist!', Response::HTTP_NOT_FOUND);
            }

            return $this->successReponse($storeUpdated);
        } catch (\Exception $exception) {

            return $this->errorResponse($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete store
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function delete()
    {
        try {
            $id = request()->route('id');
            if(!$this->storeRepo->delete($id)) {
                return $this->errorResponse('Store not exist!', Response::HTTP_NOT_FOUND);
            }

            return $this->successReponse();
        } catch (\Exception $exception) {

            return $this->errorResponse($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * View detail
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function detail()
    {
        try {
            $id = request()->route('id');
            $store = $this->storeRepo->detail($id);

            return $this->successReponse($store);
        } catch (\Exception $exception) {
            
            return $this->errorResponse($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
