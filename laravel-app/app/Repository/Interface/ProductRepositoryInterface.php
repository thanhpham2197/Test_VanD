<?php

namespace App\Repository\Interface;

interface ProductRepositoryInterface
{
    public function getList($conditon);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function detail(int $id);
}