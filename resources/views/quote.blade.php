@extends('include.header')
@section('content')
    <div class="content">
        <!-- Quotes List -->
        <div class="card card-default">
            <div class="card-header">
                <h2>Quotes</h2>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                    Add Quotes
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
                <table class="table" id="quotes">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Email</th>
                            <th class="text-center" scope="col">Service</th>
                            <th class="text-center" scope="col">Message</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($quotes as $quote)
                            <tr>
                                <td class="text-center">{{ $quote->name }}</td>
                                <td class="text-center">{{ $quote->email }}</td>
                                <td class="text-center">{{ $quote->service }}</td>
                                <td class="text-center">{{ $quote->message }}</td>
                                <td style=" display:flex; justify-content:center;align-items:center">
                                    <a href="#" class="text-info mr-3 edit_quote"
                                        data-quote-id="{{ $quote->id }}"><span
                                            class="mdi mdi-pencil text-center"></span></a>
                                    <form method="POST" action="{{ route('quotes.destroy', $quote->id) }}" class="inner">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger mr-3 text-center"><span
                                                class="mdi mdi-trash-can"></span></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-danger">No quotes Added Yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-right" style="margin-bottom: 2%;">
            {{ $quotes->links() }}

        </div>
    </div>


    <!-- Add quote Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add quote</h5>
                </div>
                <div class="modal-body">
                    <form id="addquoteForm" method="post" action="{{ route('quotes.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" id="add_name" name="name" class="form-control" placeholder="Name">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" id="add_email" name="email" class="form-control"
                                    placeholder="Name@gmail.com">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Service</label>
                                <select id="add_service" name="service" class="form-control">
                                    <option value="" selected disabled>Select A Service</option>
                                    <option value="Custom PHP Development Service">Custom PHP Development Service</option>
                                    <option value="React.Js Development Service">React.Js Development Service</option>
                                    <option value="React Native App Development Service">React Native App Development
                                        Service</option>
                                    <option value="IOS App Development Service">IOS App Development Service</option>
                                    <option value="Full-Stack Development Service">Full-Stack Development Service</option>
                                    <option value="PHP And React.js Migration ">PHP And React.js Migration </option>
                                    <option value="Custom API Development">Custom API Development</option>
                                    <option value="Maintenance and Support">Maintenance and Support</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Message</label>
                                <textarea type="text" id="add_message" name="message" class="form-control" placeholder="Hello Laravel 11 ....."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="addButton">Add quote</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit quote Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit quote</h5>
                </div>
                <div class="modal-body">
                    <form id="editquoteForm" method="post" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_quoteId" name="quoteId">
                        <input type="hidden" id="edit_method" name="method">
                        <input type="hidden" id="edit_old_image" name="old_image">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" id="edit_name" name="name" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" id="edit_email" name="email" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Service</label>
                                <select id="edit_service" name="service" class="form-control">
                                    <option value="" selected disabled>Select A Service</option>
                                    <option value="Custom PHP Development Service">Custom PHP Development Service</option>
                                    <option value="React.Js Development Service">React.Js Development Service</option>
                                    <option value="React Native App Development Service">React Native App Development
                                        Service</option>
                                    <option value="IOS App Development Service">IOS App Development Service</option>
                                    <option value="Full-Stack Development Service">Full-Stack Development Service</option>
                                    <option value="PHP And React.js Migration ">PHP And React.js Migration </option>
                                    <option value="Custom API Development">Custom API Development</option>
                                    <option value="Maintenance and Support">Maintenance and Support</option>
                                </select>
                            </div>


                            <div class="form-group col-md-6">
                                <label>Message</label>
                                <textarea type="text" id="edit_message" name="message" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="editButton">Update quote</button>
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
        $(document).ready(function() {
            $('.edit_quote').click(function() {
                var quoteId = $(this).data('quote-id');
                $.ajax({
                    url: '/quotes/' + quoteId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#editModal').modal('show');
                        $('#edit_quoteId').val(response.id);
                        $('#edit_name').val(response.name);
                        $('#edit_email').val(response.email);
                        $('#edit_service').val(response.service);
                        $('#edit_message').val(response.message);
                        $('#editquoteForm').attr('action', '/quotes/' + quoteId);
                    }
                });
            });

            $('#addquoteForm').submit(function(e) {
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
                            text: 'Quote Added Successfully',
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

            $('#editquoteForm').submit(function(e) {
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
                            text: 'Quote Updated Successfully',
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
