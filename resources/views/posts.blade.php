@extends('new_layouts.app')

@section('title', 'Posts Page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8"> <!-- Adjust the width as per your requirement -->
                <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Post your thoughts!</h5>

                            <!-- Additional title and description fields -->
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Enter title">
                                @error('title')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
                                @error('description')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
