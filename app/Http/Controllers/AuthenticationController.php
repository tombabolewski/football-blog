<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthenticationController extends Controller
{
    public function __construct(private UserRepo $userRepo) 
    {
    }

    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        $userData = $registerRequest->validated();
        $user = $this->userRepo->create(...$userData);
        $userResource = UserResource::make($user);
        return response()->json($userResource, Response::HTTP_CREATED);
    }

    public function login(LoginRequest $loginRequest): JsonResponse
    {
        
    }

    public function logout(): JsonResponse
    {
        
    }

    public function forgotPassword(ForgotPasswordRequest $forgotPasswordRequest):  JsonResponse
    {
        
    }
}
