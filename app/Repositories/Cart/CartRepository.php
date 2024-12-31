<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CartRepository implements CartRepositoryInterface
{
    /**
     * Retrieve all carts with their associated products.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Cart::with('products')->get();
    }

    /**
     * Find a specific cart by ID with its associated products.
     *
     * @param string $id
     * @return Cart
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id): Cart
    {
        return Cart::with('products')->findOrFail($id);
    }

    /**
     * Retrieve or create a cart for a specific user.
     *
     * @param int $userId
     * @return Cart
     */
    public function getUserCart(int $userId): Cart
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    /**
     * Add a product to a cart or increment its quantity if it already exists.
     *
     * @param int $cartId
     * @param int $productId
     * @param int $quantity
     * @return CartProduct
     */
    public function addProductToCart(int $cartId, int $productId, int $quantity): CartProduct
    {
        $cartItem = CartProduct::updateOrCreate(
            ['cart_id' => $cartId, 'product_id' => $productId],
            ['quantity' => DB::raw("quantity + $quantity")]
        );

        return $cartItem;
    }

    /**
     * Remove a product from a cart.
     *
     * @param int $cartId
     * @param int $productId
     * @return string
     *
     * @throws ModelNotFoundException
     */
    public function removeProductFromCart(int $cartId, int $productId): string
    {
        $cartProduct = CartProduct::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->firstOrFail();

        $cartProduct->delete();

        return 'Product removed from cart successfully.';
    }
}
