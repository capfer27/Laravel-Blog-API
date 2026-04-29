<?php

namespace App\Http\Controllers\Api\V1\Blog\Post;

use App\Enums\PostEvent;
use App\Enums\PostError;
use App\Http\Controllers\Api\CoreApiController;
use App\Http\Requests\Api\V1\Blog\Post\PostStoreRequest;
use App\Http\Resources\Api\V1\Blog\Post\PostResource;
use App\Jobs\ProcessPostModeration;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PostController extends CoreApiController
{
    // Get all posts
    public function index(Request $request) 
    {
        $query = Post::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->get();

        return $this->successResponse(PostResource::collection($posts));
    }

    // Create a post
    public function create(PostStoreRequest $request): JsonResponse
    {
        $post = Post::create($request->validated());

        // Trigger the 10-minute Job.
        ProcessPostModeration::dispatch($post)->delay(now()->addMinutes(10));
        

        return $this->successResponse(new PostResource($post), PostEvent::POST_CREATED->value, Response::HTTP_CREATED);
    }

    // Show a single post
    public function show(int $id) {
        $post = Post::find($id);

        if (!$post) {
            return $this->errorResponse(PostError::POST_NOT_FOUND->value, [], Response::HTTP_NOT_FOUND);
        }

        return $this->successResponse(new PostResource($post));
    }

    // delete a specific post (Soft Delete)
    public function delete(int $id): JsonResponse
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->errorResponse(PostError::POST_NOT_FOUND->value, [], Response::HTTP_NOT_FOUND);
        }

        $post->delete();

        return $this->successResponse([], PostEvent::POST_DELETED->value);
    }

}
