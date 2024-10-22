@extends('new_layouts.app')

@section('page_name', 'Add a New Restaurant')

@section('content')
<br>
<div class="container">
    <form action="{{ route('restaurants.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <h5 class="mb-4">Restaurant From</h5>

                <div class="mb-3">
                    <label for="name" class="form-label">Restaurant Name:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter restaurant name">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter restaurant description"></textarea>
                    @error('description')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="menu_image" class="form-label">Menu Image:</label>
                    <input type="file" class="form-control" id="menu_image" name="menu_image" accept="image/*">
                    @error('menu_image')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="operating_hours" class="form-label">Operating Hours:</label>
                    <input type="text" class="form-control" id="operating_hours" name="operating_hours" placeholder="Enter operating hours">
                    @error('operating_hours')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location:</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter restaurant location">
                    @error('location')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 py-2 px-4 rounded-lg shadow-md">Add Restaurant</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
