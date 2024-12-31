<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'description',
        'quantity',
        'image',
        // 'sku' // Uncomment if SKU is to be included in mass assignment
    ];

    /**
     * Get the carts associated with the product.
     *
     * This method defines a many-to-many relationship between products and carts.
     * The pivot table 'cart_product' includes a 'quantity' field and timestamps.
     *
     * @return BelongsToMany
     */
    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_product')
            ->withPivot('quantity') // Include quantity in the pivot table
            ->withTimestamps(); // Include timestamps for the pivot table
    }
}
