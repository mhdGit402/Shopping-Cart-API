<?php

namespace App\Services;

use App\Repositories\User\UserRepository;

class UserService
{
    /**
     * The user repository instance.
     *
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * Create a new UserService instance.
     *
     * @param UserRepository $userRepository The user repository instance.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create a new user with the given data.
     *
     * @param array $data The data for the new user.
     * @return mixed The created user instance or result from the repository.
     */
    public function createUser(array $data)
    {
        return $this->userRepository->create($data);
    }

    /**
     * Retrieve a user by their email address.
     *
     * @param string $email The email address of the user to retrieve.
     * @return mixed The user instance if found, null otherwise.
     */
    public function getUserByEmail(string $email)
    {
        return $this->userRepository->findByEmail($email);
    }
}
