<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserTokenResource;
use App\Models\User;
use App\Repos\UserRepo;
use App\Support\Permission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthenticationController extends Controller
{
    public function __construct(private UserRepo $userRepo)
    {
    }

    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        $userData = $registerRequest->validated();
        $user = $this->userRepo->create($userData);
        $userResource = UserResource::make($user);
        return response()->json($userResource, Response::HTTP_CREATED);
    }

    public function login(LoginRequest $loginRequest): JsonResponse
    {
        $credentials = $loginRequest->validated();
        try {
            /** @var User $user */
            $user = User::query()->withEmail($credentials['email'])->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new UnauthorizedHttpException('jwt-auth', 'Wrong e-mail or password', $e, 1010);
        }
        if ($user->can(Permission::USER_LOGIN->value)) {
            throw new AccessDeniedHttpException('You are not allowed to login', null, 1020);
        }
        $token = auth()->attempt($credentials);
        if ($token === false) {
            throw new UnauthorizedHttpException('jwt-auth', 'Wrong e-mail or password', null, 1010);
        }
        return response()->json(UserTokenResource::make((object)['token' => $token]));
    }

    public function forgotPassword(ForgotPasswordRequest $forgotPasswordRequest): JsonResponse
    {
        Password::sendResetLink($forgotPasswordRequest->validated());

        // We always return a success message, even if the e-mail could not be sent
        // because we don't want to expose if the user exists
        return response()->json(['message' => 'Reset link sent']);
    }

    public function resetPassword(ResetPasswordRequest $resetPasswordRequest): JsonResponse
    {
        $isPasswordReset = Password::reset($resetPasswordRequest->validated(), function (User $user, string $password) {
            $user->password = $password;
            $user->setRememberToken(Str::random(60));
            $user->save();
        }) === Password::PASSWORD_RESET;
        if ($isPasswordReset === false) {
            throw new BadRequestHttpException('Could not reset password. Check provided token, e-mail and password', null, 1020);
        }
        return response()->json(['message' => 'Password reset successfully']);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
