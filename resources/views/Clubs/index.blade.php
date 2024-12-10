@extends('new_layouts.app')

@section('page_name', 'All Clubs')

@section('button_url')
    {{ route('clubs.create') }}
@endsection

@section('button_label')
    Add New Club
@endsection

@section('content')
    @if ($clubs->isEmpty())
        <div class="text-center">
            <p>No clubs available at the moment. Please check back later.</p>
        </div>
    @else
        <div class="container mt-5">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                @foreach ($clubs as $club)
                    <div class="col">
                        <div class="card border rounded-5">
                            <div class="card-header d-flex align-items-center">
                                <div class="ms-3">
                                    <h6 class="mb-0 fs-sm">By, {{ $club->user->name }}</h6>
                                    <span class="text-muted fs-sm">{{ $club->created_at->format('F j, Y') }}</span>
                                </div>
                            </div>

                            <div class="card-body">
                                @if ($club->image)
                                    <img src="{{ asset('storage/' . $club->image) }}" class="card-img-top" alt="{{ $club->name }} Image" style="height: 200px; object-fit: contain;">
                                @else
                                    <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="No image available" style="height: 200px; object-fit: cover;">
                                @endif

                                <h4 class="card-title mt-3">{{ $club->name }}</h4>
                                <p class="text-muted mb-0">{{ Str::limit($club->description, 100) }}</p>
                                <p class="text-muted mb-2"><strong>Category:</strong> {{ $club->category }}</p>
                            </div>

                            <div class="card-footer">
                                <form action="{{ route('users.profile') }}" method="POST" class="me-auto">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $club->user->id }}">
                                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Contact Club Founder</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
