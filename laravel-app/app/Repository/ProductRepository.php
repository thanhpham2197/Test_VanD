<?php

namespace App\Repository;

use App\Models\Product;
use App\Repository\Interface\ProductRepositoryInterface;
use App\Repository\Interface\StoreRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

    private $storeRepo;

    public function getModel()
    {
        return Product::class;
    }

    /**
     * Constructor of class
     */
    public function __construct(StoreRepositoryInterface $storeRepo)
    {
        $this->storeRepo = $storeRepo;
        parent::__construct();
    }
    /**
     * Get list product
     */
    public function getList($request)
    {
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : 10;

            return $this->model
            ->searchList($request)
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->get();
        } catch(\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Create
     * 
     * @param array $attributes
     * 
     * @return bool|mixed
     */
    public function create(array $attributes)
    {
        try {
            $store = $this->storeRepo->detail($attributes['store_id']);
            if($store) {
                return $this->model->create($attributes);
            }

            return false;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update
     * 
     * @param $id
     * @param array $attributes
     * 
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        try {
            $result = $this->detail($id);
            $store = $this->storeRepo->detail($attributes['store_id']);
            if ($result && $store) {
                $result->update($attributes);
                return $result;
            }
    
            return false;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Delete
     *
     * @param $id
     * 
     * @return bool
     */
    public function delete($id)
    {
        try {
            $result = $this->detail($id);
            if ($result) {
                $result->delete();
    
                return true;
            }
    
            return false;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
    /**
     * Get one
     * 
     * @param $id
     * 
     * @return mixed
     */
    public function detail($id)
    {
        $result = $this->model->find($id);

        return $result;
    }
}
