<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // Product name is required, must be a string, and max length is 255 characters
            'price' => 'required|numeric|min:0', // Product price is required, must be a numeric value, and cannot be negative
            'description' => 'nullable|string', // Product description is optional and must be a string if provided
            'quantity' => 'required|integer|min:0', // Available quantity is required, must be an integer, and cannot be negative
            'image' => 'nullable|url', // Image URL is optional and must be a valid URL if provided
            // 'sku' => 'nullable|string|unique:products,sku', // Uncomment if SKU is needed and must be unique
        ];
    }

    public function messages()
    {
        return [
            'price.min' => 'The product price must be a positive number.',
            'quantity.min' => 'The product price must be a positive number.',
        ];
    }
}
