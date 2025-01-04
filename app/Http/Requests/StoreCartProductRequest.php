<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool True if the user is authorized, false otherwise.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to make this request
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $productId = $this->input('product_id');
            $quantityRequested = $this->input('quantity');
            $product = Product::find($productId);
            if ($product) {
                if ($quantityRequested > $product->stock) {
                    $validator->errors()->add('quantity', 'The requested quantity exceeds the available stock.');
                }
            }
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string> The validation rules for the request.
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id', // Product ID is required and must exist in the products table
            'quantity' => 'required|integer|min:1', // Quantity is required, must be an integer, and at least 1
        ];
    }

    /**
     * Get the custom validation messages for the request.
     *
     * @return array<string, string> The custom validation messages.
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'The product ID is required.',
            'product_id.exists' => 'The selected product ID does not exist in our records.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least 1.',
        ];
    }
}
