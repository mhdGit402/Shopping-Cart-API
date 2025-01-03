<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CartPolicy
{
    /**
     * Determine if the user can view the cart.
     *
     * @param User $user
     * @param Cart $cart
     * @return bool|Response
     */
    public function viewCart(User $user, Cart $cart): bool|Response
    {
        return $this->hasAccess($user, $cart)
            ? Response::allow()
            : Response::deny('You are not authorized to view this cart.');
    }

    /**
     * Determine if the user can update the cart.
     *
     * @param User $user
     * @param Cart $cart
     * @return bool|Response
     */
    public function updateCart(User $user, Cart $cart): bool|Response
    {
        return $this->hasAccess($user, $cart)
            ? Response::allow()
            : Response::deny('You are not authorized to update this cart.');
    }

    /**
     * Check if the user has access to the cart.
     *
     * @param User $user
     * @param Cart $cart
     * @return bool
     */
    private function hasAccess(User $user, Cart $cart): bool
    {
        return $user->hasRole('admin') ||
            $user->hasRole('maintainer') ||
            $user->id === $cart->user_id;
    }
}
