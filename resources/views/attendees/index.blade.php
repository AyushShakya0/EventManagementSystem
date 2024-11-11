@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item {{ request()->is('categories') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('categories.index') }}">Category</a>
                            </li>
                            <li class="nav-item {{ request()->is('events') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('events.index') }}">Event</a>
                            </li>
                            <li class="nav-item {{ request()->is('attendees') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('attendees.index') }}">Attendees</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <h3>All Attendees</h3>

                <!-- Button trigger modal for creating attendee -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#createAttendeeModal">
                    Add New Attendee
                </button>

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Event</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendees as $attendee)
                            <tr id="attendee-{{ $attendee->id }}">
                                <td>{{ $attendee->id }}</td>
                                <td>{{ $attendee->name }}</td>
                                <td>{{ $attendee->email }}</td>
                                <td>{{ $attendee->phone }}</td>
                                <td>{{ $attendee->event->title }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm edit-attendee"
                                        data-bs-toggle="modal" data-bs-target="#editAttendeeModal"
                                        data-id="{{ $attendee->id }}" data-name="{{ $attendee->name }}"
                                        data-email="{{ $attendee->email }}" data-phone="{{ $attendee->phone }}"
                                        data-event="{{ $attendee->event_id }}">Edit</button>

                                    <button type="button" class="btn btn-danger btn-sm delete-attendee"
                                        data-id="{{ $attendee->id }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Attendee Modal -->
    <div class="modal fade" id="createAttendeeModal" tabindex="-1" aria-labelledby="createAttendeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createAttendeeModalLabel">Create Attendee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createAttendeeForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <small class="text-danger error-message" id="nameError"></small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                            <small class="text-danger error-message" id="emailError"></small>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                            <small class="text-danger error-message" id="phoneError"></small>
                        </div>
                        <div class="form-group">
                            <label for="event_id">Event:</label>
                            <select name="event_id" id="event_id" class="form-control" required>
                                @foreach ($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger error-message" id="eventIdError"></small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveAttendeeButton" data-bs-dismiss="modal">Save
                        Attendee</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Attendee Modal -->
    <div class="modal fade" id="editAttendeeModal" tabindex="-1" aria-labelledby="editAttendeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAttendeeModalLabel">Edit Attendee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAttendeeForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="attendee-id" name="attendee_id">
                        <div class="form-group">
                            <label for="edit-name">Name:</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-email">Email:</label>
                            <input type="email" name="email" id="edit-email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-phone">Phone:</label>
                            <input type="text" name="phone" id="edit-phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-event">Event:</label>
                            <select name="event_id" id="edit-event" class="form-control" required>
                                @foreach ($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Update Attendee</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Create Attendee - Submit the form via AJAX
            $('#saveAttendeeButton').on('click', function() {
                // Clear any existing error messages
                $('.error-message').text('');

                // Collect form data
                let formData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    event_id: $('#event_id').val()
                };

                $.ajax({
                    url: "{{ route('attendees.store') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        alert("Attendee created successfully!");
                        $('#createAttendeeModal').modal('hide'); // Hide the modal
                        $('#createAttendeeForm')[0].reset(); // Reset form fields


                        console.log(response);
                        // Optionally append the new attendee to the table
                        $('tbody').append(`
                            <tr id="attendee-${response.id}">
                                <td>${response.id}</td>
                                <td>${response.name}</td>
                                <td>${response.email}</td>
                                <td>${response.phone}</td>
                                <td>${response.event_title}</td>
                                <td>
                                    <a href="{{ url('attendees') }}/${response.id}/edit" class="btn btn-warning btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm delete-attendee" data-id="${response.id}">Delete</button>
                                </td>
                            </tr>
                        `);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.name) $('#nameError').text(errors.name[0]);
                            if (errors.email) $('#emailError').text(errors.email[0]);
                            if (errors.phone) $('#phoneError').text(errors.phone[0]);
                            if (errors.event_id) $('#eventIdError').text(errors.event_id[0]);
                        } else {
                            alert("An error occurred. Please try again.");
                        }
                    }
                });
            });

            // Handle Delete Button Click
            $('.delete-attendee').on('click', function() {
                var attendeeId = $(this).data('id'); // Get the attendee ID
                var deleteUrl = `/attendees/${attendeeId}`; // Construct the delete URL

                // Confirm before deletion
                if (!confirm("Are you sure you want to delete this attendee?")) {
                    return;
                }

                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    success: function(response) {
                        // Remove the attendee row from the table
                        $('#attendee-' + attendeeId).remove();
                        alert("Attendee deleted successfully.");
                    },
                    error: function(xhr) {
                        alert("An error occurred while trying to delete the attendee.");
                        console.log(xhr.responseText);
                    }
                });
            });

            // Populate the modal with the attendee data when the "Edit" button is clicked
            $('.edit-attendee').on('click', function() {
                var attendeeId = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var phone = $(this).data('phone');
                var eventId = $(this).data('event');

                // Set the values in the modal fields
                $('#attendee-id').val(attendeeId);
                $('#edit-name').val(name);
                $('#edit-email').val(email);
                $('#edit-phone').val(phone);
                $('#edit-event').val(eventId);
            });

            // Submit the form using AJAX for the update
            $('#editAttendeeForm').on('submit', function(e) {
                e.preventDefault();

                var attendeeId = $('#attendee-id').val();
                var formData = $(this).serialize();

                $.ajax({
                    url: '/attendees/' + attendeeId,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        // Update the table with the new values
                        var row = $('#attendee-' + attendeeId);
                        row.find('td:nth-child(2)').text(response.name);
                        row.find('td:nth-child(3)').text(response.email);
                        row.find('td:nth-child(4)').text(response.phone);
                        row.find('td:nth-child(5)').text(response.event_title);

                        // Close the modal
                        $('#editAttendeeModal').modal('hide');
                        alert("Attendee updated successfully!");
                    },
                    error: function(xhr) {
                        alert("An error occurred while updating the attendee.");
                    }
                });
            });

        });
    </script>
@endsection
