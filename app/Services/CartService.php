<?php

namespace App\Services;

use App\Repositories\Cart\CartRepositoryInterface;

class CartService
{
    protected CartRepositoryInterface $cartRepository;

    /**
     * Inject the CartRepository dependency.
     */
    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Retrieve all carts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCarts()
    {
        return $this->cartRepository->all();
    }

    /**
     * Retrieve a specific cart by its ID.
     *
     * @param int $id
     * @return \App\Models\Cart|null
     */
    public function getCartById(int $id)
    {
        return $this->cartRepository->find($id);
    }

    /**
     * Add a product to the user's cart.
     *
     * @param int $userId
     * @param int $productId
     * @param int $quantity
     * @return \App\Models\CartProduct
     */
    public function addToCart(int $userId, int $productId, int $quantity)
    {
        $cart = $this->cartRepository->getUserCart($userId);

        return $this->cartRepository->addProductToCart(
            $cart->id,
            $productId,
            $quantity
        );
    }

    /**
     * Remove a product from the user's cart.
     *
     * @param int $userId
     * @param int $productId
     * @return bool|string
     */
    public function removeFromCart(int $userId, int $productId)
    {
        $cart = $this->cartRepository->getUserCart($userId);

        return $this->cartRepository->removeProductFromCart(
            $cart->id,
            $productId
        );
    }
}
