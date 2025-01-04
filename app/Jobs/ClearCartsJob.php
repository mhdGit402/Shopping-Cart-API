<?php

namespace App\Jobs;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ClearCartsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Retrieve all unchecked carts with their associated products
        $carts = Cart::where('checkout', 0)->with('products')->get();

        // Log the number of carts being processed
        Log::info("Processing " . $carts->count() . " unchecked carts.");

        foreach ($carts as $cart) {
            // Extract product IDs from the cart
            $productIds = $cart->products->pluck('id')->toArray();

            // Fetch all products in a single query and index them by ID
            $productsInDb = Product::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($cart->products as $product) {
                $quantityInCart = $product->pivot->quantity;

                // Check if the product exists in the database
                if (!isset($productsInDb[$product->id])) {
                    Log::warning("Product with ID {$product->id} not found in the database.");
                    continue;
                }

                $productInDb = $productsInDb[$product->id];

                // Calculate the new quantity
                $newQuantity = $productInDb->quantity - $quantityInCart;

                // Ensure quantity does not go negative
                if ($newQuantity < 0) {
                    Log::error("Insufficient stock for product: {$productInDb->name}. Requested: {$quantityInCart}, Available: {$productInDb->quantity}");
                    continue;
                }

                // Update the product quantity
                $productInDb->quantity = $newQuantity;

                // Save the changes
                $productInDb->save();
                Log::info("Updated quantity for product: {$productInDb->name}. New quantity: {$newQuantity}");
            }

            // Delete the cart after processing
            $cart->delete();
            Log::info("Deleted cart with ID: {$cart->id} after processing.");
        }

        Log::info("Finished processing all unchecked carts.");
    }
}
