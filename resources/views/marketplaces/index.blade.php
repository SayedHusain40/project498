@extends('new_layouts.app')
@section('page_name', 'All Marketplace')
@section('button_url')
    {{ route('marketplace.show') }}
@endsection

@section('button_label')
    Upload Marketplace
@endsection
@section('content')

    <!-- if there are not porducts-->
    @if ($items->isEmpty())
        <div class="text-center">
            {{-- <img src="{{ asset('images/') }}" alt="No products available" style="max-width: 50%; height: auto;"> --}}
            <p>No products available at the moment. Please check back later.</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
            @foreach ($items as $item)
                <div class="col">
                    <div class="card border rounded-5">
                        <div class="card-header d-flex align-items-center">
                            <div class="avatar rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-user" style="font-size: 20px;"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fs-sm">By, {{ $item->user->name }}</h6>
                                <span class="text-muted fs-sm">{{ $item->created_at->format('F j, Y') }}</span>
                            </div>
                        </div>

                        <div class="card-body">
                            @if ($item->image_path)
                                <a href="{{ asset('storage/' . $item->image_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $item->image_path) }}" class="card-img-top"
                                        alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                                </a>
                            @else
                                <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="No image available"
                                    style="height: 200px; object-fit: cover;">
                            @endif

                            <h4 class="card-title mt-3">{{ $item->title }}</h4>
                            <p class="text-muted mb-0">{{ Str::limit($item->description, 100) }}</p>
                            <p class="text-muted mb-2">{{ $item->category }} | Condition:
                                {{ ucfirst($item->condition) }}</p>
                            <span class="text-success fw-bold mt-2">Price:
                                @if ($item->price === null)
                                    Free
                                @else
                                    BD {{ number_format($item->price, 3) }}
                                @endif
                            </span>
                        </div>

                        <div class="card-footer">
                            <form action="{{ route('users.profile') }}" method="POST" class="me-auto">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $item->user->id }}">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill">Contact Me</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
