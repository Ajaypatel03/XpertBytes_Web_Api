@extends('include.header')
@section('content')
    <div class="content">
        <!-- ContactUs List -->
        <div class="card card-default">
            <div class="card-header">
                <h2>ContactUs</h2>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                    Add Contact
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
                <table class="table" id="contacts">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Email</th>
                            <th class="text-center" scope="col">Subject</th>
                            <th class="text-center" scope="col">Message</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contactUs as $contact)
                            <tr>
                                <td class="text-center">{{ $contact->name }}</td>
                                <td class="text-center">{{ $contact->email }}</td>
                                <td class="text-center">{{ $contact->subject }}</td>
                                <td class="text-center">{{ $contact->message }}</td>
                                <td style=" display:flex; justify-content:center;align-items:center">
                                    <a href="#" class="text-info mr-3 edit_contact"
                                        data-contact-id="{{ $contact->id }}"><span
                                            class="mdi mdi-pencil text-center"></span></a>
                                    <form method="POST" action="{{ route('contacts.destroy', $contact->id) }}"
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
                                <td colspan="5" class="text-center text-danger">No contacts Added Yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-right" style="margin-bottom: 2%;">
            {{ $contactUs->links() }}

        </div>
    </div>


    <!-- Add contact Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add contact</h5>
                </div>
                <div class="modal-body">
                    <form id="addcontactForm" method="post" action="{{ route('contacts.store') }}"
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
                                <label>Subject</label>
                                <input type="text" id="add_subject" name="subject" class="form-control"
                                    placeholder="contact">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Message</label>
                                <textarea type="text" id="add_message" name="message" class="form-control" placeholder="Hello Laravel 11 ....."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="addButton">Add contact</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit contact Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit contact</h5>
                </div>
                <div class="modal-body">
                    <form id="editcontactForm" method="post" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_contactId" name="contactId">
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
                                <label>Subject</label>
                                <input type="text" id="edit_subject" name="subject" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Message</label>
                                <textarea type="text" id="edit_message" name="message" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="editButton">Update contact</button>
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
            $('.edit_contact').click(function() {
                var contactId = $(this).data('contact-id');
                $.ajax({
                    url: '/contacts/' + contactId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#editModal').modal('show');
                        $('#edit_contactId').val(response.id);
                        $('#edit_name').val(response.name);
                        $('#edit_email').val(response.email);
                        $('#edit_subject').val(response.subject);
                        $('#edit_message').val(response.message);
                        $('#editcontactForm').attr('action', '/contacts/' + contactId);
                    }
                });
            });

            $('#addcontactForm').submit(function(e) {
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
                            text: 'contact added successfully',
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

            $('#editcontactForm').submit(function(e) {
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
                            text: 'contact updated successfully',
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
