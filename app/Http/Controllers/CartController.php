<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->cartService->getAllCarts());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        $cart = $this->cartService->createCart($request->validated());
        return response()->json(["message" => "Cart created.", "product" => $cart], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cart = $this->cartService->getCartById($id);
        return response()->json($cart, 201);
    }
}
