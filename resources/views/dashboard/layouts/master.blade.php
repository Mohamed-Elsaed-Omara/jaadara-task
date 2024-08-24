<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>General Dashboard &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/bootstrap-iconpicker.css') }}">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.2/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/toastr.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            @include('dashboard.layouts.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad
                        Nauval Azhar</a>
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="jquery-3.7.1.min.js"></script>
    <script src="{{ asset('dashboard/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/modules/popper.js') }}"></script>
    <script src="{{ asset('dashboard/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('dashboard/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/stisla.js') }}"></script>

    <script src="{{ asset('dashboard/assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="//cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('dashboard/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/toastr.min.js') }}"></script>



    <!-- Template JS File -->
    <script src="{{ asset('dashboard/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/custom.js') }}"></script>

    <script>
        // toastr options
        toastr.options.progressBar = true;
        // validation error
        @if ($errors->any())

            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}")
            @endforeach
        @endif
    </script>

    <script>
        // Upload Preview
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
        // Delete Post Usnig Ajax
        $(document).ready(function() {
            $('body').on('click', '.delete-item', function(e) {
                e.preventDefault();

                let url = $(this).attr('href');
                let csrfToken = $('meta[name="csrf-token"]').attr('content');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            method: 'DELETE',
                            url: url,
                            data: {
                                _token: csrfToken // Add CSRF token
                            },
                            success: function(response) {
                                if (response.status == 'success') {

                                    toastr.success(response.message)
                                    window.location.reload();

                                } else if (response.status == 'error') {

                                    toastr.error(response.message)
                                }
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    }
                });
            });
        });
        // Create Post Using Ajax
        $(document).ready(function() {
            $('#create-post-form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('posts.store') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success('Post created successfully');

                    },
                    error: function(response) {
                        toastr.error('Failed to create post');
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
