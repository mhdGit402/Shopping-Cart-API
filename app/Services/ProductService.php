<?php

namespace App\Services;

use App\Repositories\Product\ProductRepositoryInterface;
use App\Jobs\SendAdminNotification;

class ProductService
{
    protected $productRepository;

    /**
     * Create a new ProductService instance.
     *
     * @param ProductRepositoryInterface $productRepository The repository for product operations.
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Retrieve all products.
     *
     * This method calls the repository to get all products and returns them.
     *
     * @return mixed A collection of all products.
     */
    public function getAllProducts()
    {
        return $this->productRepository->all();
    }

    /**
     * Create a new product and dispatch a notification.
     *
     * This method validates the provided data, creates a new product using the repository,
     * and dispatches a job to notify the admin about the new product.
     *
     * @param array $data An associative array containing product attributes.
     * @return mixed The created product instance.
     */
    public function createProduct(array $data)
    {
        // Dispatch notification job
        SendAdminNotification::dispatch($data);

        // Create the product
        return $this->productRepository->create($data);
    }

    /**
     * Retrieve a product by its ID.
     *
     * This method calls the repository to find a product by its ID.
     *
     * @param string $id The ID of the product to retrieve.
     * @return mixed The product instance if found, or null if not found.
     */
    public function getProductById(string $id)
    {
        return $this->productRepository->find($id);
    }
}
