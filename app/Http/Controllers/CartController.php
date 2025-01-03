<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartProductRequest;
use App\Http\Requests\DeleteCartProductRequest;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    protected CartService $cartService;

    /**
     * Inject the CartService dependency.
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of all carts.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $carts = $this->cartService->getAllCarts();
        return response()->json($carts, 200);
    }

    /**
     * Display the specified cart by ID.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $cart = $this->cartService->getCartById($id);

        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        return response()->json($cart, 200);
    }

    /**
     * Add a product to the cart.
     *
     * @param StoreCartProductRequest $request
     * @return JsonResponse
     */
    public function addToCart(StoreCartProductRequest $request): JsonResponse
    {
        $userId = auth()->id(); // Simplified user ID retrieval
        $validatedData = $request->validated();

        $cartItem = $this->cartService->addToCart(
            $userId,
            $validatedData['product_id'],
            $validatedData['quantity']
        );

        return response()->json([
            'message' => 'Product added to cart successfully',
            'data' => $cartItem,
        ], 201);
    }

    /**
     * Remove a product from the cart.
     *
     * @param DeleteCartProductRequest $request
     * @return JsonResponse
     */
    public function removeFromCart(DeleteCartProductRequest $request): JsonResponse
    {
        $userId = auth()->id();
        $productId = $request->validated('product_id');

        $isRemoved = $this->cartService->removeFromCart($userId, $productId);

        if (!$isRemoved) {
            return response()->json(['error' => 'Failed to remove product from cart'], 400);
        }

        return response()->json(['message' => 'Product removed from cart successfully'], 200);
    }

    /**
     * Handles the checkout process for the authenticated user's cart.
     *
     * This method attempts to checkout the cart for the currently authenticated user.
     * If the checkout is successful, it returns a JSON response with a success message
     * and the updated cart data. If the checkout fails, it returns an error message.
     *
     * @return JsonResponse A JSON response indicating the result of the checkout process.
     * @throws AuthenticationException If the user is not authenticated.
     */
    public function checkoutCart(): JsonResponse
    {
        // Ensure the user is authenticated
        $userId = auth()->user()->id;

        // Attempt to checkout the cart
        $isCheckout = $this->cartService->checkoutCart($userId);

        // Check if the checkout was successful
        if (!$isCheckout) {
            return response()->json(['error' => 'Failed to checkout cart.'], 400);
        }

        // Return success response with cart data
        return response()->json(['message' => 'Cart checked out successfully.', 'cart' => $isCheckout], 200);
    }
}
