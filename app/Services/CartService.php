<?php

namespace App\Services;

use App\Models\Cart;
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
     * @return Collection
     */
    public function getAllCarts()
    {
        return $this->cartRepository->all();
    }

    /**
     * Retrieve a specific cart by its ID.
     *
     * @param int $id
     * @return Cart|null
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
     * @return CartProduct
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

    /**
     * Finalizes the checkout process for the specified user's cart.
     *
     * This method retrieves the cart associated with the given user ID
     * and processes the checkout. It returns the updated cart instance.
     *
     * @param int $userId The ID of the user whose cart is being checked out.
     * @return Cart The updated cart instance after checkout.
     * @throws ModelNotFoundException If the cart for the specified user does not exist.
     */
    public function checkoutCart(int $userId): Cart
    {
        // Retrieve and checkout the user's cart
        $cart = $this->cartRepository->checkout($userId);

        return $cart;
    }
}
