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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Product name
            $table->decimal('price', 10, 2); // Product price
            $table->text('description')->nullable(); // Product description
            $table->unsignedInteger('quantity'); // Available quantity
            // $table->string('sku')->unique(); // Stock Keeping Unit
            $table->string('image')->nullable(); // URL or path to product image
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
