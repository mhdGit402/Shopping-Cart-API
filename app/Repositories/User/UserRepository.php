<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new user and generate an API token.
     *
     * This method accepts an array of user data, creates a new user,
     * and generates an API token for the user.
     *
     * @param array $data The data for creating the user, including required fields.
     * @return array An array containing the created user instance and the generated API token.
     */
    public function create(array $data)
    {
        $user = User::create($data);
        $token = $user->createToken('User Token')->plainTextToken;
        // Log::info(['User Created. ' => $data, 'User API Token' => $token]);
        return [
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * Find a user by their email address.
     *
     * This method retrieves a user by their email. If the user is not found,
     * it will throw a ModelNotFoundException.
     *
     * @param string $email The email address of the user to retrieve.
     * @return User The user instance associated with the given email.
     */
    public function findByEmail(string $email)
    {
        return User::where('email', $email)->firstOrFail()->load('tokens');
    }
}
