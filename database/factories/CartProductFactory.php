<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CartProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cart = Cart::pluck("id");
        $product = Product::pluck("id");

        return [
            'cart_id' => $cart->random(),
            'product_id' => $product->random(),
            'quantity' => $this->faker->numberBetween(1, 10), // Random quantity between 1 and 10
        ];
    }
}
