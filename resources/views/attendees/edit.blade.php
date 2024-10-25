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
                    <h3>Edit Attendee</h3>
                    <form action="{{ route('attendees.update', $attendee->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $attendee->name }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $attendee->email }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ $attendee->phone }}" required>
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="event_id">Event:</label>
                            <select name="event_id" id="event_id" class="form-control" required>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ $attendee->event_id == $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
                                @endforeach
                            </select>
                            @error('event_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Attendee</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

