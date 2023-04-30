<?php

namespace App\Repository;

use App\Models\Store;
use App\Repository\Interface\StoreRepositoryInterface;

class StoreRepository extends BaseRepository implements StoreRepositoryInterface
{
    public function getModel()
    {
        return Store::class;
    }

    /**
     * Get list store
     */
    public function getList($request)
    {
        $page = $request->has('page') ? $request->get('page') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;

        return $this->model
        ->with('user')
        ->searchList($request)
        ->limit($limit)
        ->offset(($page - 1) * $limit)
        ->get();
    }

    /**
     * Create
     * 
     * @param array $attributes
     * 
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
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
        $result = $this->detail($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
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
        $result = $this->detail($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
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
