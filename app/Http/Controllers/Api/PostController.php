<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InternalServerErrorHttpException;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexPostsRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Repos\PostRepo;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PostController extends Controller
{
    private const DEFAULT_INDEX_QUANTITY = 10;
    private const DEFAULT_INDEX_ORDER_FIELD = 'created_at';
    private const DEFAULT_INDEX_ORDER_DESC = true;

    public function __construct(private PostRepo $postRepo)
    {
        $this->authorizeResource(Post::class, 'post');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexPostsRequest $indexPostsRequest): AnonymousResourceCollection
    {
        $quantity = $indexPostsRequest->input('per_page', static::DEFAULT_INDEX_QUANTITY);
        $orderBy = $indexPostsRequest->input('order_by', static::DEFAULT_INDEX_ORDER_FIELD);
        $orderDesc = $indexPostsRequest->input('order_desc', static::DEFAULT_INDEX_ORDER_DESC);
        $posts = Post::query()->orderBy($orderBy, $orderDesc ? 'desc' : 'asc')->paginate($quantity);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $post = $this->postRepo->createForUser($request->validated(), $user);
        return response()->json(PostResource::make($post->loadMissing('images')), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json(PostResource::make($post->loadMissing('images')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post = $this->postRepo->update($post, $request->validated());
        return response()->json(PostResource::make($post));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $isDeleted = $this->postRepo->delete($post);
        if ($isDeleted === false) {
            throw new InternalServerErrorHttpException('Unable to delete the resource');
        }
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
