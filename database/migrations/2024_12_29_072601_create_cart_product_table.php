<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_product', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete(); // Foreign key referencing carts
            $table->foreignId('product_id')->constrained()->cascadeOnDelete(); // Foreign key referencing products
            $table->unsignedInteger('quantity'); // Quantity of the product in the cart
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_product');
    }
};
