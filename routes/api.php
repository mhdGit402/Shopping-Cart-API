<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route for creating a user
Route::post('user', [UserController::class, 'store']);

// Grouping routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    // Routes for user-related actions
    Route::prefix('user')->group(function () {
        // Route for showing a specific user's API token
        Route::get('{user}', [UserController::class, 'show'])->middleware('permission:view tokens');
    });

    // Resource routes for products
    Route::apiResource('product', ProductController::class);

    // Routes for cart-related actions
    Route::prefix('cart')->group(function () {
        // Only users with the 'view all carts' permission can access this route
        Route::get('/', [CartController::class, 'index'])->middleware('permission:view all carts');
        Route::get('{cart}', [CartController::class, 'show']);
        Route::post('add', [CartController::class, 'addToCart']);
        Route::delete('remove', [CartController::class, 'removeFromCart']);
        Route::post('checkout', [CartController::class, 'checkoutCart']);
    });
});
