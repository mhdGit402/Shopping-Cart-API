<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id', // User ID is required and must exist in the users table
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
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user ID is invalid.',
        ];
    }
}
