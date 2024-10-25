@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                <div>
                    <h3>All Attendees</h3>
                    <a href="{{ route('attendees.create') }}" class="btn btn-primary mb-3">Add New Attendee</a>
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
                            <tr>
                                <td>{{ $attendee->id }}</td>
                                <td>{{ $attendee->name }}</td>
                                <td>{{ $attendee->email }}</td>
                                <td>{{ $attendee->phone }}</td>
                                <td>{{ $attendee->event->title }}</td>
                                <td>
                                    <a href="{{ route('attendees.edit', $attendee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('attendees.destroy', $attendee->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

