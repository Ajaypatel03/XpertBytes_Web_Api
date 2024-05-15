@extends('include.header')
@section('content')
    <div class="content">
        <!-- Blogs List -->
        <div class="card card-default">
            <div class="card-header">
                <h2>Blogs</h2>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                    Add Blog
                </button>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('alert-success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success!</strong> {{ Session::get('alert-success') }}
                    </div>
                @endif
                <table class="table" id="blogs">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Title</th>
                            <th class="text-center" scope="col">Image</th>
                            <th class="text-center" scope="col">Slug</th>
                            <th class="text-center" scope="col">Description</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($blogs as $blog)
                            <tr>
                                <td class="text-center">{{ $blog->title }}</td>
                                <td class="text-center">
                                    <img src="{{ asset('images/' . $blog->image) }}" alt="Blog Image"
                                        style="max-width: 100px; max-height: 100px;">
                                </td>
                                <td class="text-center">{{ $blog->slug }}</td>
                                <td class="text-center">{{ $blog->description }}</td>
                                <td style=" display:flex; justify-content:center;align-items:center">
                                    <a href="#" class="text-info mr-3 edit_blog"
                                        data-blog-id="{{ $blog->id }}"><span
                                            class="mdi mdi-pencil text-center"></span></a>
                                    <form method="POST" action="{{ route('blogs.destroy', $blog->id) }}" class="inner">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger mr-3 text-center"><span
                                                class="mdi mdi-trash-can"></span></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-danger">No Blogs Added Yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Blog Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Blog</h5>
                </div>
                <div class="modal-body">
                    <form id="addBlogForm" method="post" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Title</label>
                                <input type="text" id="add_title" name="title" class="form-control"
                                    placeholder="Title">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Image</label>
                                <input type="file" id="add_image" name="image" class="form-control"
                                    onchange="previewImage(event, 'add')">
                                <img id="add_image_preview" src="{{ asset('images/no-image.png') }}" alt="Image Preview"
                                    style="max-width: 100px; max-height: 100px;">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Slug</label>
                                <input type="text" id="add_slug" name="slug" class="form-control"
                                    placeholder="blog.com">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <input type="text" id="add_description" name="description" class="form-control"
                                    placeholder="Hello Laravel 11 .....">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="addButton">Add Blog</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Blog Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Blog</h5>
                </div>
                <div class="modal-body">
                    <form id="editBlogForm" method="post" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_blogId" name="blogId">
                        <input type="hidden" id="edit_method" name="method">
                        <input type="hidden" id="edit_old_image" name="old_image">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Title</label>
                                <input type="text" id="edit_title" name="title" class="form-control"
                                    placeholder="Title">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Image</label>
                                <input type="file" id="edit_image" name="image" class="form-control"
                                    onchange="previewImage(event, 'edit')">
                                <img id="edit_image_preview" src="{{ asset('images/no-image.png') }}"
                                    alt="Image Preview" style="max-width: 100px; max-height: 100px;">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Slug</label>
                                <input type="text" id="edit_slug" name="slug" class="form-control"
                                    placeholder="blog.com">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <input type="text" id="edit_description" name="description" class="form-control"
                                    placeholder="Hello Laravel 11 .....">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="editButton">Update Blog</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        function previewImage(event, type) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var imgElement;
                if (type === 'add') {
                    imgElement = document.getElementById('add_image_preview');
                } else {
                    imgElement = document.getElementById('edit_image_preview');
                }
                imgElement.src = reader.result;
            }
            reader.readAsDataURL(input.files[0]);
        }

        $(document).ready(function() {
            $('.edit_blog').click(function() {
                var blogId = $(this).data('blog-id');
                $.ajax({
                    url: '/blogs/' + blogId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#editModal').modal('show');
                        $('#edit_blogId').val(response.id);
                        $('#edit_title').val(response.title);
                        $('#edit_slug').val(response.slug);
                        $('#edit_description').val(response.description);
                        //$('#edit_old_image').val(response.image);
                        $('#edit_image_preview').attr('src', '{{ asset('images/') }}/' +
                            response.image);
                        $('#editBlogForm').attr('action', '/blogs/' + blogId);
                    }
                });
            });

            $('#addBlogForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');
                var url = $(this).attr('action');
                var method = 'POST';

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#addModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Blog added successfully',
                        }).then((result) => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = 'An error occurred. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = '';
                            var errors = xhr.responseJSON.errors;
                            for (var key in errors) {
                                errorMessage += errors[key][0] + '\n';
                            }
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                        });
                    }
                });
            });

            $('#editBlogForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('_method', 'PUT'); // Add the method override for PUT
                var url = $(this).attr('action');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: 'POST', // Use POST for form submission
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#editModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Blog updated successfully',
                        }).then((result) => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = 'An error occurred. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = '';
                            var errors = xhr.responseJSON.errors;
                            for (var key in errors) {
                                errorMessage += errors[key][0] + '\n';
                            }
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                        });
                    }
                });
            });

        });
    </script>
@endsection
