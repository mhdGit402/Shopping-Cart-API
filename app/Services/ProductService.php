<?php

namespace App\Services;

use App\Repositories\Product\ProductRepositoryInterface;
use App\Jobs\SendAdminNotification;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->all();
    }

    public function createProduct(array $data)
    {
        // Dispatch notification job
        SendAdminNotification::dispatch($data);

        // Create the product
        return $this->productRepository->create($data);
    }

    public function getProductById(string $id)
    {
        return $this->productRepository->find($id);
    }
}
