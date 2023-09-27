<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexPostsRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repos\PostRepo;
use Illuminate\Http\Request;

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
    public function index(IndexPostsRequest $indexPostsRequest)
    {
        $quantity = $indexPostsRequest->input('per_page', static::DEFAULT_POSTS_QUANTITY);
        $orderBy = $indexPostsRequest->input('order_by', static::DEFAULT_INDEX_ORDER_FIELD);
        $orderDesc = $indexPostsRequest->input('order_desc', static::DEFAULT_INDEX_ORDER_DESC);
        $posts = Post::query()->orderBy($orderBy, $orderDesc)->paginate($quantity);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = $this->postRepo->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
