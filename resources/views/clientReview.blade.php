@extends('include.header')
@section('content')
    <div class="content">
        <!-- Clients List -->
        <div class="card card-default">
            <div class="card-header">
                <h2>Clients</h2>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                    Add Clients
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
                <table class="table" id="clients">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Image</th>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Description</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset('images/' . $client->image) }}" alt="client Image"
                                        style="max-width: 100px; max-height: 100px;">
                                </td>
                                <td class="text-center">{{ $client->name }}</td>
                                <td class="text-center">{{ $client->description }}</td>
                                <td style=" display:flex; justify-content:center;align-items:center">
                                    <a href="#" class="text-info mr-3 edit_client"
                                        data-client-id="{{ $client->id }}"><span
                                            class="mdi mdi-pencil text-center"></span></a>
                                    <form method="POST" action="{{ route('clients.destroy', $client->id) }}"
                                        class="inner">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger mr-3 text-center"><span
                                                class="mdi mdi-trash-can"></span></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-danger">No clients Added Yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add client Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add client</h5>
                </div>
                <div class="modal-body">
                    <form id="addclientForm" method="post" action="{{ route('clients.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" id="add_name" name="name" class="form-control" placeholder="Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Image</label>
                                <input type="file" id="add_image" name="image" class="form-control"
                                    onchange="previewImage(event, 'add')">
                                <img id="add_image_preview" src="{{ asset('images/no-image.png') }}" alt="Image Preview"
                                    style="max-width: 100px; max-height: 100px;">
                            </div>
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea type="text" id="add_description" name="description" class="form-control"
                                    placeholder="Hello Laravel 11 ....."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="addButton">Add client</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit client Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit client</h5>
                </div>
                <div class="modal-body">
                    <form id="editclientForm" method="post" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_clientId" name="clientId">
                        <input type="hidden" id="edit_method" name="method">
                        <input type="hidden" id="edit_old_image" name="old_image">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" id="edit_name" name="name" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Image</label>
                                <input type="file" id="edit_image" name="image" class="form-control"
                                    onchange="previewImage(event, 'edit')">
                                <img id="edit_image_preview" src="{{ asset('images/no-image.png') }}" alt="Image Preview"
                                    style="max-width: 100px; max-height: 100px;">
                            </div>
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea type="text" id="edit_description" name="description" class="form-control"
                                    placeholder="Hello Laravel 11 ....."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="editButton">Update client</button>
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
            $('.edit_client').click(function() {
                var clientId = $(this).data('client-id');
                $.ajax({
                    url: '/clients/' + clientId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#editModal').modal('show');
                        $('#edit_clientId').val(response.id);
                        $('#edit_name').val(response.name);
                        $('#edit_description').val(response.description);
                        //$('#edit_old_image').val(response.image);
                        $('#edit_image_preview').attr('src', '{{ asset('images/') }}/' +
                            response.image);
                        $('#editclientForm').attr('action', '/clients/' + clientId);
                    }
                });
            });

            $('#addclientForm').submit(function(e) {
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
                            text: 'client added successfully',
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

            $('#editclientForm').submit(function(e) {
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
                            text: 'client updated successfully',
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
