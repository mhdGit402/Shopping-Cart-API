<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;


interface CartRepositoryInterface
{
    /**
     * Retrieve all carts.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find a specific cart by its ID.
     *
     * @param int $id
     * @return Cart
     */
    public function find(int $id): Cart;

    /**
     * Retrieve or create a cart for a specific user.
     *
     * @param int $userId
     * @return Cart
     */
    public function getUserCart(int $userId): Cart;

    /**
     * Add a product to the user's cart.
     *
     * @param int $userId
     * @param int $productId
     * @param int $quantity
     * @return CartProduct|JsonResponse
     */
    public function addProductToCart(int $userId, int $productId, int $quantity): CartProduct|JsonResponse;

    /**
     * Remove a product from the user's cart.
     *
     * @param int $userId
     * @param int $productId
     * @return bool
     */
    public function removeProductFromCart(int $userId, int $productId): string;

    /**
     * Checkout the user's cart.
     *
     * @param int $userId
     * @return Cart
     */
    public function checkout(int $userId): Cart;
}
