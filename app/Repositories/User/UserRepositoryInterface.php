<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    /**
     * Create a new user with the provided data.
     *
     * This method should accept an array of user data and return the created user instance.
     *
     * @param array $data An associative array containing user attributes such as name, email, and password.
     * @return mixed The created user instance or an array containing user details and token.
     */
    public function create(array $data);

    /**
     * Find a user by their email address.
     *
     * This method should return a user instance associated with the given email.
     * If no user is found, it should throw an exception.
     *
     * @param string $email The email address of the user to retrieve.
     * @return mixed The user instance if found, or null if not found.
     */
    public function findByEmail(string $email);
}
