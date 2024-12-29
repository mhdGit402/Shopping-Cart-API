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
        return [
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'description' => $this->faker->realText(200),
            'quantity' => $this->faker->numberBetween(1, 100),
            // 'sku' => $this->faker->unique()->numerify('ABC###'),
            'image' => $this->faker->imageUrl(640, 480, 'technics'), // Generates a random image URL
        ];
    }
}
