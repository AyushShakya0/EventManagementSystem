@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>All Attendees</h3>

                <!-- Button trigger modal for creating attendee -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createAttendeeModal">
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
                                <a href="{{ route('attendees.edit', $attendee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm delete-attendee" data-id="{{ $attendee->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Attendee Modal -->
    <div class="modal fade" id="createAttendeeModal" tabindex="-1" aria-labelledby="createAttendeeModalLabel" aria-hidden="true">
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
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger error-message" id="eventIdError"></small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveAttendeeButton">Save Attendee</button>
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

            // Submit the form via AJAX when "Save" button is clicked
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
        });
    </script>
@endsection
