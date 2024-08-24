@extends('dashboard.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Create Post</h1>
        </div>

        <a href="{{ route('posts.index') }}" class="btn btn-primary mb-3" >Go Back</a>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Post</h4>
            </div>
            <div class="card-body">
                <form id="create-post-form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <textarea name="body" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>

@endsection
