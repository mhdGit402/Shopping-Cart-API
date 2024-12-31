<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCartProductRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id', // Product ID is required and must exist in the products table
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
        ];
    }
}
