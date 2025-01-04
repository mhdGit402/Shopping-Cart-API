<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a random stock value
        $stock = $this->faker->numberBetween(1, 100);
        return [
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'description' => $this->faker->realText(200),
            'stock' => $stock,
            'quantity' => $this->faker->numberBetween(1, $stock),
            'image' => $this->faker->imageUrl(640, 480, 'technics'), // Generates a random image URL
        ];
    }
}
