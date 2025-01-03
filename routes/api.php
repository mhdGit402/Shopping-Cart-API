<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Create a new user.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('user', [UserController::class, 'store']);

/**
 * Group routes that require authentication.
 */
Route::middleware('auth:sanctum')->group(function () {

    /**
     * User-related routes.
     */
    Route::prefix('user')->group(function () {
        /**
         * Show a specific user's API token.
         *
         * @param int $user The ID of the user.
         * @return \Illuminate\Http\Response
         */
        Route::get('{user}', [UserController::class, 'show'])
            ->middleware('permission:view tokens');
    });

    /**
     * Product-related routes.
     */
    Route::prefix('product')->group(function () {
        /**
         * Retrieve a list of products.
         *
         * @return \Illuminate\Http\Response
         */
        Route::get('/', [ProductController::class, 'index']);

        /**
         * Show a specific product.
         *
         * @param int $cart The ID of the product.
         * @return \Illuminate\Http\Response
         */
        Route::get('{cart}', [ProductController::class, 'show']);

        /**
         * Store a new product.
         *
         * @return \Illuminate\Http\Response
         */
        Route::post('store', [ProductController::class, 'store'])
            ->middleware('permission:create product');
    });

    /**
     * Cart-related routes.
     */
    Route::prefix('cart')->group(function () {
        /**
         * Retrieve all carts for the authenticated user.
         *
         * @return \Illuminate\Http\Response
         */
        Route::get('/', [CartController::class, 'index'])
            ->middleware('permission:view all carts');

        /**
         * Show a specific cart.
         *
         * @param int $cart The ID of the cart.
         * @return \Illuminate\Http\Response
         */
        Route::get('{cart}', [CartController::class, 'show']);

        /**
         * Add a product to the cart.
         *
         * @return \Illuminate\Http\Response
         */
        Route::post('add', [CartController::class, 'addToCart']);

        /**
         * Remove a product from the cart.
         *
         * @return \Illuminate\Http\Response
         */
        Route::delete('remove', [CartController::class, 'removeFromCart']);

        /**
         * Checkout the cart.
         *
         * @return \Illuminate\Http\Response
         */
        Route::post('checkout', [CartController::class, 'checkoutCart']);
    });
});
