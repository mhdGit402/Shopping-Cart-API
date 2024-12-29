<?php

namespace Database\Seeders;

use App\Models\CartProduct;
use Illuminate\Database\Seeder;

class CartProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CartProduct::factory(30)->create(); // Create 30 cart_product entries
    }
}
