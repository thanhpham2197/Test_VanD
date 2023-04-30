<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductListResource;
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
        $productList = $this->productRepo->getList($request);
        return $this->successReponse(ProductListResource::collection($productList));
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
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'store_id' => $request->store_id
        ];
        $productCreated = $this->productRepo->create($data);

        return $this->successReponse($productCreated);
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
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'store_id' => $request->store_id
        ];

        $productUpdated = $this->productRepo->update(request()->route('id'), $data);
        if(!$productUpdated) {
            return $this->errorResponse(__('validation.product_update_fail'), Response::HTTP_NOT_FOUND);
        }

        return $this->successReponse($productUpdated);
    }

    /**
     * Delete store
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function delete()
    {
        $id = request()->route('id');
        if(!$this->productRepo->delete($id)) {
            return $this->errorResponse(__('validation.product_exist'), Response::HTTP_NOT_FOUND);
        }

        return $this->successReponse();
    }
    /**
     * View detail
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function detail()
    {
        $id = request()->route('id');
        $product = $this->productRepo->detail($id);

        return $this->successReponse($product);
    }
}
