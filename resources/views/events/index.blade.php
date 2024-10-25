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
                    <h3>All Events</h3>
                    <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Add New Event</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Location</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->description }}</td>
                                <td>{{ $event->date }}</td>
                                <td>{{ $event->time }}</td>
                                <td>{{ $event->location }}</td>
                                <td>{{ $event->category->name }}</td>
                                <td>
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
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
