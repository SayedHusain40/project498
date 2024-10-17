@extends('new_layouts.app')

@section('page_name', 'Marketplace')

@section('content')

    <div class="container">
        <h5 class="mb-4">Marketplace Upload</h5>

        <form method="post" action="{{ route('marketplace.upload') }}?tab=marketplace" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Item Title:</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter item title" value="{{ old('title') }}">
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Item Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter item description">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" placeholder="Enter price" value="{{ old('price') }}">
                        @error('price')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Select a category</option>
                            <option value="books" {{ old('category') == 'books' ? 'selected' : '' }}>Books</option>
                            <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>Electronics</option>
                        </select>
                        @error('category')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="condition" class="form-label">Condition:</label>
                        <select class="form-select" id="condition" name="condition">
                            <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Used</option>
                        </select>
                        @error('condition')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image:</label>
                        <input class="form-control" type="file" id="image" name="image">
                        @error('image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 px-4 rounded-lg shadow-md">Upload Item</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
