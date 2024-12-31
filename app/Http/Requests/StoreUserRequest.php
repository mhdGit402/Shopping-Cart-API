<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> The validation rules for the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // Name is required, must be a string, and max length is 255 characters
            'email' => 'required|email|unique:users,email|max:255', // Email is required, must be a valid email format, unique in users table, and max length is 255 characters
            'password' => 'required|string|min:8', // Password is required, must be a string, and minimum length is 8 characters
            'email_verified_at' => 'nullable|date', // Email verified at can be null and must be a valid date if provided
            'remember_token' => 'nullable|string|max:100', // Remember token can be null, must be a string, and max length is 100 characters
        ];
    }
}
