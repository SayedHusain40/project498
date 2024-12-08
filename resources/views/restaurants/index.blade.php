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
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                @foreach ($restaurants as $restaurant)
                    <div class="col">
                        <div class="card border rounded-5">
                            <!-- Card Header -->
                            <div class="card-header d-flex align-items-center">
                                @if ($restaurant->user->profile_image)
                                    <div class="rounded-circle"
                                        style="width: 60px; height: 60px; display: flex; justify-content: center; align-items: center; background-color: #f0f0f0; margin-right:5px;">
                                        <img src="{{ asset('storage/' . $restaurant->user->profile_image) }}"
                                            alt="Profile Image" class="img-fluid rounded-circle"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    </div>
                                @else
                                    <div class="rounded-circle"
                                        style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; background-color: #f0f0f0; margin-right:5px;">
                                        <i class="fas fa-user" style="font-size: 30px; color: #aaa;"></i>
                                    </div>
                                @endif
                                <div class="ms-3">
                                    <h6 class="mb-0 fs-sm">By, {{ $restaurant->user->name }}</h6>
                                    <span class="text-muted fs-sm">{{ $restaurant->created_at->format('F j, Y') }}</span>
                                </div>
                            </div>


                            <!-- Card Body -->
                            <div class="card-body">
                                @if ($restaurant->menu_image)
                                    <a href="{{ asset('storage/' . $restaurant->menu_image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $restaurant->menu_image) }}" class="card-img-top"
                                            alt="{{ $restaurant->name }} Menu" style="height: 200px; object-fit: cover;">
                                    </a>
                                @else
                                    <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top"
                                        alt="No image available" style="height: 200px; object-fit: cover;">
                                @endif

                                <h4 class="card-title mt-3">{{ $restaurant->name }}</h4>
                                <p class="text-muted mb-0">{{ Str::limit($restaurant->description, 100) }}</p>
                                <p class="text-muted mb-2"><strong>Operating Hours:</strong>
                                    {{ $restaurant->operating_hours }}</p>
                                <p class="text-muted"><strong>Location:</strong> {{ $restaurant->location }}</p>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer">
                                <form action="{{ route('users.profile') }}" method="POST" class="me-auto">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $restaurant->user->id }}">
                                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Contact Me</button>
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
