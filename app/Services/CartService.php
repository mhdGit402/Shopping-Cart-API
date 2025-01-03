<?php

namespace App\Services;

use App\Models\Cart;
use App\Repositories\Cart\CartRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    protected CartRepositoryInterface $cartRepository;

    /**
     * Inject the CartRepository dependency.
     *
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Retrieve all carts.
     *
     * @return Collection|Cart[] A collection of all carts.
     */
    public function getAllCarts(): Collection
    {
        return $this->cartRepository->all();
    }

    /**
     * Retrieve a specific cart by its ID.
     *
     * @param int $id The ID of the cart to retrieve.
     * @return Cart|null The cart instance or null if not found.
     * @throws AuthorizationException If the user is not authorized to view the cart.
     */
    public function getCartById(int $id): ?Cart
    {
        $cart = $this->cartRepository->find($id);

        // Authorization check
        $this->authorize('viewCart', $cart);

        return $cart;
    }

    /**
     * Add a product to the user's cart.
     *
     * @param int $userId The ID of the user.
     * @param int $productId The ID of the product to add.
     * @param int $quantity The quantity of the product to add.
     * @return mixed The cart product instance after addition.
     * @throws AuthorizationException If the user is not authorized to update the cart.
     */
    public function addToCart(int $userId, int $productId, int $quantity)
    {
        $cart = $this->cartRepository->getUserCart($userId);

        // Authorization check
        $this->authorize('updateCart', $cart);

        return $this->cartRepository->addProductToCart($cart->id, $productId, $quantity);
    }

    /**
     * Remove a product from the user's cart.
     *
     * @param int $userId The ID of the user.
     * @param int $productId The ID of the product to remove.
     * @return bool True if the product was removed, false otherwise.
     * @throws AuthorizationException If the user is not authorized to update the cart.
     */
    public function removeFromCart(int $userId, int $productId): bool
    {
        $cart = $this->cartRepository->getUserCart($userId);

        // Authorization check
        $this->authorize('updateCart', $cart);

        return $this->cartRepository->removeProductFromCart($cart->id, $productId);
    }

    /**
     * Finalizes the checkout process for the specified user's cart.
     *
     * @param int $userId The ID of the user whose cart is being checked out.
     * @return Cart The updated cart instance after checkout.
     */
    public function checkoutCart(int $userId): Cart
    {
        return $this->cartRepository->checkout($userId);
    }

    /**
     * Authorizes an action for a given ability and model.
     *
     * This method inspects the authorization policy for the specified ability
     * and model. If the action is not authorized, it throws an AuthorizationException
     * with the appropriate message.
     *
     * @param string $ability The ability being checked (e.g., 'view', 'update').
     * @param mixed $model The model instance or class name being authorized.
     *
     * @throws AuthorizationException If the action is not authorized.
     *
     * @return void
     */
    protected function authorize(string $ability, $model): void
    {
        // Inspect the policy for the given ability and model
        $response = Gate::inspect($ability, $model);

        // If the action is allowed, return early
        if ($response->allowed()) {
            return;
        }

        // If denied, throw an exception with the policy's message
        throw new AuthorizationException($response->message());
    }
}
