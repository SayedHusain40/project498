@extends('new_layouts.app')
@section('page_name', 'All Restaurants')
@section('button_url')
    {{ route('restaurants.create') }}
@endsection

@section('button_label')
    Add Restaurants
@endsection
@section('content')
    <!-- if there are not porducts-->
    @if ($restaurants->isEmpty())
        <div class="text-center">
            {{-- <img src="{{ asset('images/') }}" alt="No products available" style="max-width: 50%; height: auto;"> --}}
            <p>No products available at the moment. Please check back later.</p>
        </div>
    @else
    <div class="container mt-5">
        <h1 class="mb-4">Restaurants</h1>

        <div class="row">
            @foreach ($restaurants as $restaurant)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if ($restaurant->menu_image)
                            <img src="{{ asset('storage/' . $restaurant->menu_image) }}" alt="{{ $restaurant->name }} Menu"
                                class="card-img-top">
                        @else
                            <img src="{{ asset('path/to/default/image.png') }}" alt="No Image Available" class="card-img-top">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $restaurant->name }}</h5>
                            <p class="card-text">{{ Str::limit($restaurant->description, 100) }}</p>
                            <p class="card-text"><strong>Operating Hours:</strong> {{ $restaurant->operating_hours }}</p>
                            <p class="card-text"><strong>Location:</strong> {{ $restaurant->location }}</p>
                        </div>
                        <div class="card-footer">
                            <form action="{{ route('users.profile') }}" method="POST" class="mt-2">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $restaurant->user->id }}">
                                <button type="submit" class="btn btn-primary">Contact Me</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
@endsection
