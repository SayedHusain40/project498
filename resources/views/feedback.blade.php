@extends('new_layouts.app')

@section('title', 'Feedback Page')

@section('page_name', 'Leave Your Feedback')

@section('styles')
    <style>

        .dropdown-menu {
            background-color: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .dropdown-item {
            color: #000000;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
            border-radius: 0.25rem;
            border: 1px solid rgba(0, 0, 0, 0.125);
            display: none;
            position: absolute;
            background-color: #ffffff;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }

        .dropdown-menu.show {
            display: block;
        }

        .btn-light {
            border-color: #E0E0E0;
            border-radius: 7px;
        }
    </style>
@endsection

@section('content')
<br>
<div class="container">
    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <form method="post" action="{{ route('feedback.store') }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Feedback Form</h5>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Rate your experience:</label>
                            <div class="d-flex flex-column">
                                <!-- Rating 1 -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" value="1" id="rating1" required>
                                    <label class="form-check-label" for="rating1">
                                        1 - Very Bad
                                    </label>
                                </div>
                                <!-- Rating 2 -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" value="2" id="rating2">
                                    <label class="form-check-label" for="rating2">
                                        2 - Bad
                                    </label>
                                </div>
                                <!-- Rating 3 -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" value="3" id="rating3">
                                    <label class="form-check-label" for="rating3">
                                        3 - Mediocre
                                    </label>
                                </div>
                                <!-- Rating 4 -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" value="4" id="rating4">
                                    <label class="form-check-label" for="rating4">
                                        4 - Good
                                    </label>
                                </div>
                                <!-- Rating 5 -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" value="5" id="rating5">
                                    <label class="form-check-label" for="rating5">
                                        5 - Excellent
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="feedback" class="form-label">Feedback</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="3" placeholder="Write your feedback here...">{{ old('feedback') }}</textarea>
                            @error('feedback')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 px-4 rounded-lg shadow-md">Submit Feedback</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
