<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "price",
        "description",
        "quantity",
        "image",
        // "sku"
    ];

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_product')
            ->withPivot('quantity') // Include quantity in the pivot table
            ->withTimestamps(); // Include timestamps for the pivot table
    }
}
