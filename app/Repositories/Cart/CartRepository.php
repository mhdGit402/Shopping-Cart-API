<?php

namespace App\Repositories\Cart;

use App\Models\Cart;

class CartRepository implements CartRepositoryInterface
{

    public function all()
    {
        return Cart::with('products')->get();
    }

    public function create(array $data)
    {
        return Cart::create($data);
    }

    public function find(string $id)
    {
        return Cart::with('products')->findOrFail($id);
    }
}
