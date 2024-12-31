<?php

namespace App\Repositories\Cart;

interface CartRepositoryInterface
{
    /**
     * Retrieve all carts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): \Illuminate\Database\Eloquent\Collection;

    /**
     * Find a specific cart by its ID.
     *
     * @param int $id
     * @return \App\Models\Cart
     */
    public function find(int $id): \App\Models\Cart;

    /**
     * Retrieve or create a cart for a specific user.
     *
     * @param int $userId
     * @return \App\Models\Cart
     */
    public function getUserCart(int $userId): \App\Models\Cart;

    /**
     * Add a product to the user's cart.
     *
     * @param int $userId
     * @param int $productId
     * @param int $quantity
     * @return \App\Models\CartProduct
     */
    public function addProductToCart(int $userId, int $productId, int $quantity): \App\Models\CartProduct;

    /**
     * Remove a product from the user's cart.
     *
     * @param int $userId
     * @param int $productId
     * @return bool
     */
    public function removeProductFromCart(int $userId, int $productId): string;
}
