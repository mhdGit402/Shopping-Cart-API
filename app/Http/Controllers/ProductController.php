<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected ProductService $productService;

    /**
     * Create a new controller instance.
     *
     * @param ProductService $productService The service responsible for product operations.
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the products.
     *
     * @return JsonResponse A JSON response containing the list of products.
     */
    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        return response()->json($products);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param StoreProductRequest $request The validated request containing product data.
     * @return JsonResponse A JSON response indicating the result of the creation operation.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->validated());
        return response()->json([
            'message' => 'Product created.',
            'product' => $product,
        ], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified product.
     *
     * @param string $id The ID of the product to retrieve.
     * @return JsonResponse A JSON response containing the product data.
     */
    public function show(string $id): JsonResponse
    {
        $product = $this->productService->getProductById($id);
        return response()->json($product, JsonResponse::HTTP_OK);
    }
}
