@extends('dashboard.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Post</h1>
        </div>

        <a href="{{ route('posts.index') }}" class="btn btn-primary mb-3" >Go Back</a>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Edit Post</h4>
            </div>
            <div class="card-body">
                <form id="update-post-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $post->title }}">
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <textarea name="body" class="form-control">{{ $post->body }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('#image-preview').css({
                'background-image': 'url({{ asset($post->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            });
        });

        $(document).ready(function() {
            $('#update-post-form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('posts.update', $post->id) }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 'success') {
                            toastr.success(response.message)
                        }
                    },
                    error: function(response) {
                        toastr.error('Failed to update post');
                    }
                });
            });
        });
    </script>
@endpush
