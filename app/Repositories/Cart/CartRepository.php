<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CartRepository implements CartRepositoryInterface
{
    /**
     * Retrieve all carts with their associated products.
     *
     * @return Collection
     */
    public function all(): Collection
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

    /**
     * Process the checkout for a given user.
     *
     * This method finalizes the cart for the specified user, updating the checkout status
     * and returning the updated cart instance.
     *
     * @param int $userId The ID of the user for whom the checkout is being processed.
     * @return Cart The updated cart instance after checkout.
     * @throws ModelNotFoundException If the cart for the specified user does not exist.
     */
    public function checkout(int $userId): Cart
    {
        // Retrieve the user's cart
        $cart = Cart::where('user_id', $userId)->firstOrFail();

        // Update the checkout status
        $cart->update(['checkout' => 1]);

        // Return the updated cart
        return $cart;
    }
}
