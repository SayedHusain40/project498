@extends('new_layouts.app')

@section('page_name', 'Post a Study Session')

@section('content')
    <br>
    <div class="container">
        <form action="{{ route('study-sessions.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4">Create Study Session</h5>

                    <div class="mb-3">
                        <label for="topic" class="form-label">Topic:</label>
                        <input type="text" class="form-control" id="topic" name="topic"
                            placeholder="Enter study topic" value="{{ old('topic') }}">
                        @error('topic')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="Enter session description">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="session_date" class="form-label">Date and Time:</label>
                        <input type="datetime-local" class="form-control" id="session_date" name="session_date"
                            value="{{ old('session_date') }}"
                            min="{{ now()->setTimezone('Asia/Bahrain')->format('Y-m-d\TH:i') }}">
                        @error('session_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="location" class="form-label">Location:</label>
                        <input type="text" class="form-control" id="location" name="location"
                            placeholder="Enter location" value="{{ old('location') }}">
                        @error('location')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="course_id" class="form-label">Course:</label>
                        <select class="form-select" id="course_id" name="course_id">
                            <option value="">Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price_or_volunteer" class="form-label">Price or Volunteer:</label>
                        <select class="form-select" id="price_or_volunteer" name="price_or_volunteer">
                            <option value="">Select Option</option>
                            <option value="price" {{ old('price_or_volunteer') == 'price' ? 'selected' : '' }}>Price
                            </option>
                            <option value="volunteer" {{ old('price_or_volunteer') == 'volunteer' ? 'selected' : '' }}>
                                Volunteer</option>
                        </select>
                        @error('price_or_volunteer')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3" id="price_field" style="display: none;">
                        <label for="price" class="form-label">Price (in BD):</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" 
                            min="1" placeholder="Enter price" value="{{ old('price') }}">
                        @error('price')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 px-4 rounded-lg shadow-md">Post Study
                            Session</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('price_or_volunteer').addEventListener('change', function() {
            var priceField = document.getElementById('price_field');
            if (this.value === 'price') {
                priceField.style.display = 'block';
            } else {
                priceField.style.display = 'none';
            }
        });
        window.onload = function() {
            var priceField = document.getElementById('price_field');
            var priceOrVolunteer = document.getElementById('price_or_volunteer');
            if (priceOrVolunteer.value === 'price') {
                priceField.style.display = 'block'; 
            }
        };
    </script>
@endsection
