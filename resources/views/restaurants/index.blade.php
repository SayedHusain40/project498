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

            <div class="row">
                @foreach ($restaurants as $restaurant)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if ($restaurant->menu_image)
                                <img src="{{ asset('storage/' . $restaurant->menu_image) }}"
                                    alt="{{ $restaurant->name }} Menu" class="card-img-top img-fluid"
                                    style="width: 100%; height: 250px; object-fit: cover; cursor: pointer;"
                                    data-bs-toggle="modal" data-bs-target="#imageModal"
                                    onclick="showImage('{{ asset('storage/' . $restaurant->menu_image) }}')">
                            @else
                                <img src="{{ asset('path/to/default/image.png') }}" alt="No Image Available"
                                    class="card-img-top img-fluid" style="width: 100%; height: 250px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $restaurant->name }}</h5>
                                <p class="card-text">{{ Str::limit($restaurant->description, 100) }}</p>
                                <p class="card-text"><strong>Operating Hours:</strong> {{ $restaurant->operating_hours }}
                                </p>
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

    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="fullImage" src="" class="img-fluid" alt="Full Image">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function showImage(src) {
            document.getElementById("fullImage").src = src;
        }
    </script>
@endsection
