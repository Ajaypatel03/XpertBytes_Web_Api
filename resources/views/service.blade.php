@extends('include.header')
@section('content')
    <div class="content">
        <!-- Service List -->
        <div class="card card-default">
            <div class="card-header">
                <h2>Service</h2>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                    Add Service
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
                <table class="table" id="services">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Title</th>
                            <th class="text-center" scope="col">Icon</th>
                            <th class="text-center" scope="col">Description</th>
                            <th class="text-center" scope="col">Status</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                            <tr>
                                <td class="text-center">{{ $service->title }}</td>
                                <td class="text-center">
                                    <img src="{{ asset('images/' . $service->icon) }}" alt="service Image"
                                        style="max-width: 100px; max-height: 100px;">
                                </td>
                                <td class="text-center">{{ $service->description }}</td>
                                <td class="text-center">{{ $service->status }}</td>
                                <td style=" display:flex; justify-content:center;align-items:center">
                                    <a href="#" class="text-info mr-3 edit_service"
                                        data-service-id="{{ $service->id }}"><span
                                            class="mdi mdi-pencil text-center"></span></a>
                                    <form method="POST" action="{{ route('services.destroy', $service->id) }}"
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
                                <td colspan="5" class="text-center text-danger">No Services Added Yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add service Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add service</h5>
                </div>
                <div class="modal-body">
                    <form id="addserviceForm" method="post" action="{{ route('services.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Title</label>
                                <input type="text" id="add_title" name="title" class="form-control"
                                    placeholder="Title">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Icon</label>
                                <input type="file" id="add_icon" name="icon" class="form-control"
                                    onchange="previewImage(event, 'add')">
                                <img id="add_image_preview" src="{{ asset('images/no-image.png') }}" alt="Image Preview"
                                    style="max-width: 100px; max-height: 100px;">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <input type="text" id="add_description" name="description" class="form-control"
                                    placeholder=" ....... ">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <input type="text" id="add_status" name="status" class="form-control"
                                    placeholder="Hello Laravel 11 .....">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="addButton">Add Service</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit service Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit service</h5>
                </div>
                <div class="modal-body">
                    <form id="editserviceForm" method="post" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_serviceId" name="serviceId">
                        <input type="hidden" id="edit_method" name="method">
                        <input type="hidden" id="edit_old_image" name="old_image">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Title</label>
                                <input type="text" id="edit_title" name="title" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Icon</label>
                                <input type="file" id="edit_icon" name="icon" class="form-control"
                                    onchange="previewImage(event, 'edit')">
                                <img id="edit_image_preview" src="{{ asset('images/no-image.png') }}"
                                    alt="Image Preview" style="max-width: 100px; max-height: 100px;">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <input type="text" id="edit_description" name="description" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <input type="text" id="edit_status" name="status" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="editButton">Update Service</button>
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
            $('.edit_service').click(function() {
                var serviceId = $(this).data('service-id');
                $.ajax({
                    url: '/services/' + serviceId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#editModal').modal('show');
                        $('#edit_serviceId').val(response.id);
                        $('#edit_title').val(response.title);
                        $('#edit_description').val(response.description);
                        $('#edit_status').val(response.status);
                        //$('#edit_old_image').val(response.image);
                        $('#edit_image_preview').attr('src', '{{ asset('images/') }}/' +
                            response.icon);
                        $('#editserviceForm').attr('action', '/services/' + serviceId);
                    }
                });
            });

            $('#addserviceForm').submit(function(e) {
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
                            text: 'Service added successfully',
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

            $('#editserviceForm').submit(function(e) {
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
                            text: 'Service updated successfully',
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
