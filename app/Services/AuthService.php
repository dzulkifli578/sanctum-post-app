<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Interfaces\AuthServiceInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthService
 *
 * This service handles the business logic for user authentication, including
 * registration, login, profile retrieval, and logout operations. The service
 * implements `AuthServiceInterface` to ensure a clear contract for authentication 
 * functionalities and maintain consistency across the application.
 *
 * @package App\Services
 */
class AuthService implements AuthServiceInterface
{
    /**
     * Registers a new user and returns an authentication token.
     *
     * Creates a new user record and generates an authentication token.
     *
     * @param array $data The user registration data (name, email, password).
     * @return array An array containing a success message and the generated token.
     */
    public function register(array $data): array
    {
        $user = User::create($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'message' => 'Register successful',
            'token' => $token,
        ];
    }

    /**
     * Logs in a user and returns an authentication token.
     *
     * Checks the provided credentials, authenticates the user, and generates
     * an authentication token. If the user is already logged in, an exception
     * is thrown.
     *
     * @param array $credentials The login credentials (email, password).
     * @return array An array containing a success message and the generated token.
     * @throws Exception If the user is not found, the password is incorrect,
     * or the user is already logged in.
     */
    public function login(array $credentials): array
    {
        $email = $credentials['email'];
        $password = $credentials['password'];

        $user = User::where('email', $email)->first();

        if (!$user)
            throw new Exception('User not found');

        if (!Hash::check($password, $user->password))
            throw new Exception('Password incorrect');

        if ($user->tokens()->where('name', 'auth_token')->first())
            throw new Exception('User is already logged in');

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'message' => 'Login successful',
            'token' => $token,
        ];
    }

    /**
     * Retrieves the profile of the authenticated user.
     *
     * @return array An array containing the user's profile data wrapped in a
     * UserResource instance.
     * @throws Exception If the user is not authenticated.
     */
    public function profile(): array
    {
        $data = auth()->user();

        if (!$data)
            throw new Exception('User not authenticated');

        return ['data' => new UserResource($data)];
    }

    /**
     * Logs out the authenticated user by deleting their authentication tokens.
     *
     * @return array An array containing a success message.
     * @throws Exception If the user is not authenticated or if the token
     * could not be deleted.
     */
    public function logout(): array
    {
        $token = auth()->user()->tokens()->delete();

        if (!$token)
            throw new Exception('User not authenticated');

        return ['message' => 'Logout successful'];
    }
}