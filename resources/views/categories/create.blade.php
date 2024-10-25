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
                <div>
                    <h3>Create Category</h3>
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Create Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
