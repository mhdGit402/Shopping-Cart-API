<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CartProduct extends Pivot
{

    use HasFactory;

    protected $fillable = [
        "cart_id",
        "product_id",
        "quantity"
    ];

    // Define required relationships
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}