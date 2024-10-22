@extends('new_layouts.app')

@section('page_name', 'Marketplace Upload')

@section('content')
    <br>
    <div class="container">
        <form method="post" action="{{ route('marketplace.upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4"> Upload From</h5>
                    <div class="mb-3">
                        <label for="title" class="form-label">Item Title:</label>
                        <input type="text" class="form-control" id="title" name="title"
                            placeholder="Enter item title" value="{{ old('title') }}">
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
                        <label for="price_option" class="form-label">Price Option:</label>
                        <select class="form-select" id="price_option" name="price_option">
                            <option value="">Select a price option</option>
                            <option value="free" {{ old('price_option') == 'free' ? 'selected' : '' }}>Free</option>
                            <option value="price" {{ old('price_option') == 'price' ? 'selected' : '' }}>Set Price</option>
                        </select>
                        @error('price_option')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3" id="price_field" style="display: none;">
                        <label for="price" class="form-label">Price (in BD):</label>
                        <input type="number" class="form-control" id="price" name="price" min="1"
                            step="0.01" placeholder="Enter price" value="{{ old('price') }}">
                        @error('price')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Select a category</option>
                            <option value="books" {{ old('category') == 'books' ? 'selected' : '' }}>Books</option>
                            <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>
                                Others</option>
                        </select>
                        @error('category')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="condition" class="form-label">Condition:</label>
                        <select class="form-select" id="condition" name="condition">
                            <option value="">Select a condition</option>
                            <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Used</option>
                        </select>
                        @error('condition')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image:</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*">
                        @error('image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 px-4 rounded-lg shadow-md">Upload
                            Item</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('price_option').addEventListener('change', function() {
            var priceField = document.getElementById('price_field');
            if (this.value === 'price') {
                priceField.style.display = 'block';
            } else {
                priceField.style.display = 'none';
            }
        });
        window.onload = function() {
            var priceField = document.getElementById('price_field');
            var priceOption = document.getElementById('price_option');
            if (priceOption.value === 'price') {
                priceField.style.display = 'block';
            }
        };
    </script>
@endsection
