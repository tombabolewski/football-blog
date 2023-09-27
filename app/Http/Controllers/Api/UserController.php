<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\InternalServerErrorHttpException;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexUsersRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repos\UserRepo;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    private const DEFAULT_INDEX_QUANTITY = 20;
    private const DEFAULT_INDEX_ORDER_FIELD = 'created_at';
    private const DEFAULT_INDEX_ORDER_DESC = true;

    public function __construct(private UserRepo $userRepo)
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexUsersRequest $indexUsersRequest): AnonymousResourceCollection
    {
        $quantity = $indexUsersRequest->input('per_page', static::DEFAULT_POSTS_QUANTITY);
        $orderBy = $indexUsersRequest->input('order_by', static::DEFAULT_INDEX_ORDER_FIELD);
        $orderDesc = $indexUsersRequest->input('order_desc', static::DEFAULT_INDEX_ORDER_DESC);
        $users = User::query()->orderBy($orderBy, $orderDesc ? 'desc' : 'asc')->paginate($quantity);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $storeUserRequest): JsonResponse
    {
        $user = $this->userRepo->create($storeUserRequest->validated());
        $userResource = new UserResource($user);
        return response()->json($userResource, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $userResource = new UserResource($user);
        return response()->json($userResource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $updateUserRequest, User $user)
    {
        $user = $this->userRepo->update($updateUserRequest->validated());
        $userResource = new UserResource($user);
        return response()->json($userResource, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $isDeleted = $this->userRepo->delete($user);
        if ($isDeleted === false) {
            throw new InternalServerErrorHttpException('Unable to delete the resource');
        }
        return response()->json(['message' => 'User deleted successfully']);
    }
}
