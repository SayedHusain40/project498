@extends('new_layouts.app')

@section('page_name', 'Post an Event')

@section('content')
    <br>
    <div class="container">
        <form action="{{ route('announcements.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4">Create Event</h5>

                    <!-- Title Input -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter announcement title" value="{{ old('title') }}">
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description Input -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter announcement description">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Dropdown -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location Input -->
                    <div class="mb-3">
                        <label for="location" class="form-label">Location:</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" value="{{ old('location') }}">
                        @error('location')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Event Date Input -->
                    <div class="mb-3">
                        <label for="event_date" class="form-label">Event Date:</label>
                        <input type="datetime-local" class="form-control" id="event_date" name="event_date" value="{{ old('event_date') }}">
                        @error('event_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <button type="submit" class="btn btn-primary w-100 py-2 px-4 rounded-lg shadow-md">Post Event</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
