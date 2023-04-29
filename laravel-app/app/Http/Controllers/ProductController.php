<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repository\Interface\ProductRepositoryInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    use ApiResponse;

    private $productRepo;

    /**
     * Constructor of class
     */
    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
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
            $storeList = $this->productRepo->getList($request);
            return $this->successReponse($storeList);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * Create store
     * 
     * @param CreateProductRequest $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function create(CreateProductRequest $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'store_id' => $request->store_id
            ];
            $userCreated = $this->productRepo->create($data);
            if(!$userCreated) {
                return $this->errorResponse('Store not exist!');
            }

            return $this->successReponse($userCreated);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Update store
     * 
     * @param UpdateProductRequest $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(UpdateProductRequest $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'address' => $request->address,
                'store_id' => $request->store_id
            ];

            $productUpdated = $this->productRepo->update(request()->route('id'), $data);
            if(!$productUpdated) {
                return $this->errorResponse('Update product not success', Response::HTTP_NOT_FOUND);
            }

            return $this->successReponse($productUpdated);
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
            if(!$this->productRepo->delete($id)) {
                return $this->errorResponse('Product not exist!', Response::HTTP_NOT_FOUND);
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
            $store = $this->productRepo->detail($id);

            return $this->successReponse($store);
        } catch (\Exception $exception) {

            return $this->errorResponse($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
