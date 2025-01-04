<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string> The validation rules for the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // Product name is required, must be a string, and max length is 255 characters
            'price' => 'required|numeric|min:0', // Product price is required, must be a numeric value, and cannot be negative
            'description' => 'nullable|string', // Product description is optional and must be a string if provided
            'stock' => 'required|integer|min:0', // Available stock is required, must be an integer, and cannot be negative
            'quantity' => 'integer|min:0', // Available quantity is required, must be an integer, and cannot be negative
            'image' => 'nullable|url', // Image URL is optional and must be a valid URL if provided
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
            'price.min' => 'The product price must be a positive number.',
            'quantity.min' => 'The product quantity must be a positive number.',
        ];
    }
}
