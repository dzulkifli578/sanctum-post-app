<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthControllerInterface;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AuthController
 *
 * This controller handles user authentication processes, including registration,
 * login, fetching the authenticated user's profile, and logout operations.
 * It implements the `AuthControllerInterface`.
 *
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller implements AuthControllerInterface
{
    /**
     * The service handling the business logic for authentication.
     *
     * @var AuthService
     */
    private $service;

    /**
     * AuthController constructor.
     *
     * Initializes the AuthService dependency.
     *
     * @param AuthService $service The service responsible for authentication logic.
     */
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * Registers a new user and returns an authentication token.
     *
     * @param Request $request The HTTP request containing registration details (name, email, password).
     * @return JsonResponse JSON response containing a success message and the authentication token.
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);

        $array = $this->service->register($data);
        $message = $array['message'];
        $token = $array['token'];

        return response()->json([
            'message' => $message,
            'token' => $token,
        ]);
    }

    /**
     * Logs in a user and returns an authentication token.
     *
     * @param Request $request The HTTP request containing login credentials (email, password).
     * @return JsonResponse JSON response containing a success message and the authentication token.
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $array = $this->service->login($credentials);
            $message = $array['message'];
            $token = $array['token'];

            return response()->json([
                'message' => $message,
                'token' => $token,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Retrieves the profile of the authenticated user.
     *
     * @return JsonResponse JSON response containing the user's profile data.
     */
    public function profile(): JsonResponse
    {
        try {
            $array = $this->service->profile();
            $data = $array['data'];

            return response()->json([
                'profile' => $data,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Logs out the authenticated user by deleting the authentication token.
     *
     * @return JsonResponse JSON response containing a logout success message.
     */
    public function logout(): JsonResponse
    {
        try {
            $array = $this->service->logout();
            $message = $array['message'];
            return response()->json(['message' => $message]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
