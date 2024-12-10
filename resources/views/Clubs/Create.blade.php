@extends('new_layouts.app')

@section('page_name', 'Add a New Club')

@section('content')
<br>
<div class="container">
    <form action="{{ route('clubs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <h5 class="mb-4">Create a New Club</h5>

                <div class="mb-3">
                    <label for="name" class="form-label">Club Name:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter club name">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category:</label>
                    <select class="form-select" id="category" name="category">
                        <option value="Academic">Academic</option>
                        <option value="Social and Volunteer">Social and Volunteer</option>
                        <option value="Sports">Sports</option>
                        <option value="Professional Development">Professional Development</option>
                        <option value="Arts and Creativity">Arts and Creativity</option>
                        <option value="Technology and Innovation">Technology and Innovation</option>
                        <option value="Environmental Clubs">Environmental Clubs</option>
                    </select>
                    @error('category')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter club description"></textarea>
                    @error('description')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Club Image:</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    @error('image')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 py-2 px-4 rounded-lg shadow-md">Create Club</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
