<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function register(RegisterRequest $registerRequest)
    {
        $user = $this->authService->register($registerRequest->getDTO());

        return response()->json(['success' => 'User registered successfully!', 'user' => $user], 201);
    }

    public function login(LoginRequest $loginRequest)
    {
        $userData = $this->authService->login($loginRequest->getDTO());

        if (!$userData){

            return response()->json(['error' => 'Invalid Credentials'], 401);
        }

        return response()->json(['success' => $userData], 201);
    }

    public function verify(Request $request, $id, $hash)
    {
        $user_verify = $this->authService->verifyEmail($id, $hash);

        if ($user_verify) {

            return response()->json(['success' => 'Email verified successfully!'], 201);
        }

        return response()->json(['error' => 'Email verification failed!'], 422);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['success' => 'Successfully logged out'], 201);
    }
}
