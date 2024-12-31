<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    /**
     * Retrieve all products.
     *
     * This method should return a collection of all product records.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Product[] A collection of all products.
     */
    public function all();

    /**
     * Create a new product.
     *
     * This method accepts an array of product data and creates a new product record in the database.
     *
     * @param array $data An associative array containing the attributes for the new product.
     * @return Product The created product instance.
     */
    public function create(array $data);

    /**
     * Find a product by its ID.
     *
     * This method retrieves a product by its unique identifier. If the product is not found, it should throw a ModelNotFoundException.
     *
     * @param string $id The ID of the product to retrieve.
     * @return Product The product instance if found.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the product is not found.
     */
    public function find(string $id);
}
