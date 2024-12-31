<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Store a newly created user in storage.
     *
     * @param StoreUserRequest $request The validated request containing user data.
     * @return JsonResponse A JSON response indicating the result of the operation.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());
        return response()->json([
            'message' => 'User created.',
            'user' => $user
        ], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified user by email.
     *
     * @param string $email The email of the user to retrieve.
     * @return JsonResponse A JSON response containing the user data or an error message.
     */
    public function show(string $email): JsonResponse
    {
        $user = $this->userService->getUserByEmail($email);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return response()->json(['user' => $user]);
    }
}
