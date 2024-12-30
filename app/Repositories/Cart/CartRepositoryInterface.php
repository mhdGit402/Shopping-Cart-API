<?php

namespace App\Repositories\Cart;

interface CartRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function find(string $id);
}
