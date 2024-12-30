<?php

namespace App\Services;

use App\Repositories\Cart\CartRepositoryInterface;

class CartService
{
    protected $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getAllCarts()
    {
        return $this->cartRepository->all();
    }

    public function createCart(array $data)
    {
        return $this->cartRepository->create($data);
        // return response()->json(['message' => "cart created.", 'Cart' => $data], 201);
    }

    public function getCartById(string $id)
    {
        return $this->cartRepository->find($id);
    }
}
