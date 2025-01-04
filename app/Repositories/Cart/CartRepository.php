<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

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
     * Add a product to the cart.
     *
     * This method adds a product to the specified cart. If the product already exists in the cart,
     * it updates the quantity. It also ensures that the requested quantity does not exceed the available stock.
     *
     * @param int $cartId The ID of the cart.
     * @param int $productId The ID of the product to add.
     * @param int $quantity The quantity of the product to add.
     * @return CartProduct|JsonResponse The updated cart product or a JSON response in case of an error.
     */
    public function addProductToCart(int $cartId, int $productId, int $quantity): CartProduct|JsonResponse
    {
        $product = Product::findOrFail($productId);

        // Check if the requested quantity exceeds available stock
        if ($quantity + $product->quantity > $product->stock) {
            return response()->json(['message' => 'Requested quantity exceeds available stock'], 400);
        }

        // Update product quantity
        $product->quantity += $quantity;
        $product->save();

        // Add or update the product in the cart
        $cartItem = CartProduct::updateOrCreate(
            ['cart_id' => $cartId, 'product_id' => $productId],
            ['quantity' => DB::raw("quantity + $quantity")]
        );

        return $cartItem;
    }

    // Approach 2 to add a product to the cart.
    // /**
    //  * Add a product to the cart.
    //  *
    //  * This method adds a product to the specified cart. If the product already exists in the cart,
    //  * it updates the quantity. It ensures that the requested quantity does not exceed the available stock
    //  * and maintains database consistency through transactions.
    //  *
    //  * @param int $cartId The ID of the cart.
    //  * @param int $productId The ID of the product to add.
    //  * @param int $quantity The quantity of the product to add.
    //  * @return CartProduct|JsonResponse The updated cart product or a JSON response in case of an error.
    //  */
    // public function addProductToCart(int $cartId, int $productId, int $quantity): CartProduct|JsonResponse
    // {
    //     // Start a database transaction to ensure atomicity
    //     DB::beginTransaction();

    //     try {
    //         // Retrieve the product and validate its existence
    //         $product = Product::findOrFail($productId);

    //         // Check if the requested quantity exceeds available stock
    //         if ($quantity > $product->stock) {
    //             Log::warning("Requested quantity exceeds stock for product ID {$productId}. Requested: {$quantity}, Available: {$product->stock}");
    //             return response()->json(['message' => 'Requested quantity exceeds available stock'], 400);
    //         }

    //         // Retrieve or create the cart item
    //         $cartItem = CartProduct::firstOrNew(
    //             ['cart_id' => $cartId, 'product_id' => $productId]
    //         );

    //         // Calculate the new quantity for the cart item
    //         $newCartQuantity = $cartItem->quantity + $quantity;

    //         // Ensure the new cart quantity does not exceed the product's stock
    //         if ($newCartQuantity > $product->stock) {
    //             Log::error("Adding product ID {$productId} to cart ID {$cartId} would exceed stock. Current in cart: {$cartItem->quantity}, Requested: {$quantity}, Available: {$product->stock}");
    //             return response()->json(['message' => 'Adding this quantity would exceed available stock'], 400);
    //         }

    //         // Update the cart item quantity
    //         $cartItem->quantity = $newCartQuantity;
    //         $cartItem->save();

    //         // Deduct the quantity from the product's stock
    //         $product->stock -= $quantity;
    //         $product->save();

    //         // Log the successful addition
    //         Log::info("Added product ID {$productId} to cart ID {$cartId}. Quantity: {$quantity}. Remaining stock: {$product->stock}");

    //         // Commit the transaction
    //         DB::commit();

    //         return $cartItem;
    //     } catch (\Exception $e) {
    //         // Rollback the transaction on any failure
    //         DB::rollBack();

    //         // Log the error
    //         Log::error("Failed to add product ID {$productId} to cart ID {$cartId}: {$e->getMessage()}");

    //         return response()->json(['message' => 'An error occurred while adding the product to the cart'], 500);
    //     }
    // }

    /**
     * Remove a product from the cart.
     *
     * This method removes a product from the specified cart and updates the product's quantity accordingly.
     *
     * @param int $cartId The ID of the cart.
     * @param int $productId The ID of the product to remove.
     * @return string A success message.
     * @throws ModelNotFoundException If the cart product or product does not exist.
     */
    public function removeProductFromCart(int $cartId, int $productId): string
    {
        $cartProduct = CartProduct::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->firstOrFail();

        // Update product quantity
        $product = Product::findOrFail($productId);
        $product->quantity -= $cartProduct->quantity;
        $product->save();

        // Delete the cart product
        $cartProduct->delete();

        return 'Product removed from cart successfully.';
    }

    // Approach 2 to remove a product from the cart.
    //   /**
    //  * Remove a product from the cart.
    //  *
    //  * This method removes a product from the specified cart, updates the product's stock quantity,
    //  * and ensures database consistency through transactions.
    //  *
    //  * @param int $cartId The ID of the cart.
    //  * @param int $productId The ID of the product to remove.
    //  * @return string A success message.
    //  * @throws ModelNotFoundException If the cart product or product does not exist.
    //  */
    // public function removeProductFromCart(int $cartId, int $productId): string
    // {
    //     // Use a database transaction to ensure atomicity
    //     DB::beginTransaction();

    //     try {
    //         // Retrieve the cart product entry
    //         $cartProduct = CartProduct::where('cart_id', $cartId)
    //             ->where('product_id', $productId)
    //             ->firstOrFail();

    //         // Retrieve the product and validate its existence
    //         $product = Product::findOrFail($productId);

    //         // Update the product's stock quantity
    //         $newQuantity = $product->quantity + $cartProduct->quantity;

    //         if ($newQuantity < 0) {
    //             throw new \LogicException("Product stock cannot be negative. Product ID: {$productId}");
    //         }

    //         $product->quantity = $newQuantity;
    //         $product->save();

    //         // Log the stock update
    //         Log::info("Updated stock for product ID {$productId}. New quantity: {$newQuantity}");

    //         // Delete the cart product entry
    //         $cartProduct->delete();

    //         // Log the cart product removal
    //         Log::info("Removed product ID {$productId} from cart ID {$cartId}.");

    //         // Commit the transaction
    //         DB::commit();

    //         return 'Product removed from cart successfully.';
    //     } catch (ModelNotFoundException $e) {
    //         // Rollback the transaction on failure
    //         DB::rollBack();

    //         // Log the error
    //         Log::error("Failed to remove product ID {$productId} from cart ID {$cartId}: {$e->getMessage()}");

    //         throw new ModelNotFoundException('Cart product or product not found.');
    //     } catch (\LogicException $e) {
    //         // Rollback the transaction on failure
    //         DB::rollBack();

    //         // Log the error
    //         Log::error("Business logic error while removing product ID {$productId} from cart ID {$cartId}: {$e->getMessage()}");

    //         throw $e;
    //     } catch (\Exception $e) {
    //         // Rollback the transaction on any other exception
    //         DB::rollBack();

    //         // Log the error
    //         Log::critical("Unexpected error while removing product ID {$productId} from cart ID {$cartId}: {$e->getMessage()}");

    //         throw new \RuntimeException('An unexpected error occurred while removing the product from the cart.');
    //     }
    // }

    /**
     * Process the checkout for a given user.
     *
     * This method finalizes the cart for the specified user by marking it as checked out
     * and updating the stock & quantity of the products in the cart.
     *
     * @param int $userId The ID of the user for whom the checkout is being processed.
     * @return Cart|JsonResponse The updated cart instance after checkout or a JSON response in case of an error.
     * @throws ModelNotFoundException If the cart for the specified user does not exist.
     */
    public function checkout(int $userId): Cart
    {
        // Retrieve the user's cart
        $cart = Cart::where('user_id', $userId)->with('products')->firstOrFail();

        // Iterate through each product in the cart
        foreach ($cart->products as $product) {
            $quantityInCart = $product->pivot->quantity;

            // Check if the product exists in the database
            $productInDb = Product::findOrFail($product->id);
            if ($productInDb) {
                // Update the stock by subtracting the quantity in the cart
                $newStock = $productInDb->stock - $quantityInCart;

                // Update the quantity by subtracting the quantity in the cart
                $newQuantity = $productInDb->quantity - $quantityInCart;

                // Ensure stock does not go negative
                if ($newStock < 0 || $newQuantity < 0) {
                    return response()->json(['message' => 'Insufficient stock or quantity for product: ' . $productInDb->name], 400);
                }

                // Update the product stock
                $productInDb->stock = $newStock;
                $productInDb->quantity = $newQuantity;

                $productInDb->save(); // Save the changes
            }
        }

        // Mark the cart as checked out
        $cart->update(['checkout' => 1]);

        // Return the updated cart
        return $cart;
    }

    // Approach 2 to process the checkout for a given user.
    //     /**
    //  * Process the checkout for a given user.
    //  *
    //  * This method finalizes the cart for the specified user by marking it as checked out
    //  * and updating the stock & quantity of the products in the cart.
    //  *
    //  * @param int $userId The ID of the user for whom the checkout is being processed.
    //  * @return Cart|JsonResponse The updated cart instance after checkout or a JSON response in case of an error.
    //  * @throws ModelNotFoundException If the cart for the specified user does not exist.
    //  */
    // public function checkout(int $userId): Cart|JsonResponse
    // {
    //     // Start a database transaction to ensure atomicity
    //     DB::beginTransaction();

    //     try {
    //         // Retrieve the user's cart with products
    //         $cart = Cart::where('user_id', $userId)->with('products')->firstOrFail();

    //         // Iterate through each product in the cart
    //         foreach ($cart->products as $product) {
    //             $quantityInCart = $product->pivot->quantity;

    //             // Retrieve the product from the database
    //             $productInDb = Product::findOrFail($product->id);

    //             // Calculate new stock and quantity
    //             $newStock = $productInDb->stock - $quantityInCart;
    //             $newQuantity = $productInDb->quantity - $quantityInCart;

    //             // Ensure stock and quantity do not go negative
    //             if ($newStock < 0 || $newQuantity < 0) {
    //                 Log::warning("Insufficient stock for product ID {$productInDb->id}: Requested {$quantityInCart}, Available Stock: {$productInDb->stock}");
    //                 return response()->json(['message' => 'Insufficient stock or quantity for product: ' . $productInDb->name], 400);
    //             }

    //             // Update the product stock and quantity
    //             $productInDb->stock = $newStock;
    //             $productInDb->quantity = $newQuantity;
    //             $productInDb->save(); // Save the changes

    //             // Log the successful stock update
    //             Log::info("Updated stock for product ID {$productInDb->id}. New stock: {$newStock}, New quantity: {$newQuantity}");
    //         }

    //         // Mark the cart as checked out
    //         $cart->update(['checkout' => 1]);

    //         // Commit the transaction
    //         DB::commit();

    //         // Log the successful checkout
    //         Log::info("Cart checked out successfully for user ID {$userId}.");

    //         // Return the updated cart
    //         return $cart;
    //     } catch (ModelNotFoundException $e) {
    //         // Rollback the transaction on failure
    //         DB::rollBack();

    //         // Log the error
    //         Log::error("Cart not found for user ID {$userId}: {$e->getMessage()}");
    //         return response()->json(['message' => 'Cart not found for the specified user.'], 404);
    //     } catch (\Exception $e) {
    //         // Rollback the transaction on any other exception
    //         DB::rollBack();

    //         // Log the error
    //         Log::critical("Unexpected error during checkout for user ID {$userId}: {$e->getMessage()}");
    //         return response()->json(['message' => 'An unexpected error occurred during checkout.'], 500);
    //     }
    // }
}
