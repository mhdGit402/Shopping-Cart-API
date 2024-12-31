<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Retrieve all products from the database.
     *
     * This method uses Eloquent to fetch all product records.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Product[] A collection of all products.
     */
    public function all()
    {
        return Product::all();
    }

    /**
     * Create a new product in the database.
     *
     * This method accepts an array of product data and uses Eloquent to create a new product record.
     *
     * @param array $data An associative array containing the attributes for the new product.
     * @return Product The created product instance.
     */
    public function create(array $data)
    {
        return Product::create($data);
    }

    /**
     * Find a product by its ID.
     *
     * This method retrieves a product by its unique identifier. If the product is not found, it throws a ModelNotFoundException.
     *
     * @param string $id The ID of the product to retrieve.
     * @return Product The product instance if found.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the product is not found.
     */
    public function find(string $id)
    {
        return Product::findOrFail($id);
    }
}
