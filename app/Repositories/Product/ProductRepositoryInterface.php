<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function find(string $id);
}
