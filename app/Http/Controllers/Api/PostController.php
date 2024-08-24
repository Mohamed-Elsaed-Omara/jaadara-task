<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostCreateRequest;
use App\Http\Requests\Api\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get a list of all posts (Pagination)
        $posts = Post::paginate(10);

        $posts = PostResource::collection($posts);

        return response()->json([
            'posts' => $posts
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        // Validate input data
        $validatedData = $request->validated();
        // Handle image upload
        $validatedData['image'] = $this->uploadImage($request, 'image');

        // Create a new post
        $post = Auth::user()->posts()->create($validatedData);

        $data = new PostResource($post);

        return response()->json([
            'post' => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Get a single post by ID

        $post = Post::findOrFail($id);
        $data = new PostResource($post);

        return response()->json([
            'post' => $data
        ], 200);
    }

    //Users can view only their posts. (authenticated users only).

    public function getPostsOfUser()
    {
        //Get posts of current user
        $posts = Auth::user()->posts()->paginate(10);
        $data = PostResource::collection($posts);

        return response()->json([
            'posts' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        // Validate the request data
        $data = $request->validated();

        // Get the current user
        $currentUser = auth()->user();

        // Check if the authenticated user is the owner of the post
        if ($post->user_id !== $currentUser->id) {
            return response()->json([
                'message' => 'You are not authorized to update this post.'
            ], 403); // Forbidden status code
        }

        // Handle image upload
        $data['image'] = $this->uploadImage($request, 'image', $post->image);

        // Update the post with the validated data
        $post->update($data);

        // Create a resource for the updated post
        $updatedPost = new PostResource($post);

        return response()->json([
            'post' => $updatedPost
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //Delete a single post by ID (authenticated users only)

        // Get the current user
        $currentUser = auth()->user();

        // Check if the authenticated user is the owner of the post
        if ($post->user_id !== $currentUser->id) {
            return response()->json([
                'message' => 'You are not authorized to delete this post.'
            ], 403); // Forbidden status code
        }

        //image path delete
        $this->removeImage($post->image);
        // Delete the post
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully.'
        ], 200);
    }
}
