<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\PostDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PostCreateRequest;
use App\Http\Requests\Dashboard\PostUpdateRequest;
use App\Models\Post;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(PostDataTable $dataTable)
    {
        return $dataTable->render('dashboard.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->uploadImage($request, 'image');
        $data['user_id'] = auth()->user()->id;

        $post = auth()->user()->posts()->create($data);

        return response()->json(['success' => 'Post created successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['image'] = $this->uploadImage($request, 'image', $post->image);
        $data['user_id'] = auth()->user()->id;
        $post->update($data);
        return response(['status' => 'success' , 'message' => 'Updated Successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            $this->removeImage($post->image);  //image path delete
            $post->delete();
            return response(['status' => 'success' , 'message' => 'Deleted Successfully!']);

        } catch (\Exception $e) {
            return response(['status' => 'error' , 'message' => 'something went wrong!']);
        }
    }
}
