@extends('new_layouts.app')
@section('page_name', 'Marketplace')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($items as $item)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-sm" style="height: 100%; border-radius: 15px;">
                        <div class="card-header d-flex align-items-center">
                            <div class="avatar rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-user" style="font-size: 20px;"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fs-sm">{{ $item->user->name }}</h6>
                                <span class="text-muted fs-sm">{{ $item->created_at->format('F j, Y') }}</span>
                            </div>
                            <div class="dropstart ms-auto">
                                <button class="btn text-muted" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#">report</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @if ($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" class="card-img-top"
                                alt="{{ $item->title }}"
                                style="height: 180px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                        @else
                            <img src="{{ asset('path/to/placeholder-image.jpg') }}" class="card-img-top"
                                alt="No image available"
                                style="height: 180px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                        @endif
                        <div class="card-body" style="padding: 0 1.25rem;">
                            <h3>{{ $item->title }}</h3>
                            <p class="card-text" style="font-size: 0.9rem; line-height: 1.4em;">
                                {{ $item->description }}
                            </p>
                            <p class="mb-1" style="font-weight: bold;">Price: BD {{ $item->price }}</p>
                            <p class="mb-1"><strong>Condition:</strong> {{ $item->condition }}</p>
                            <p class="mb-0"><strong>Category:</strong> {{ $item->category }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <form action="{{ route('users.profile') }}" method="POST" class="me-auto">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $item->user->id }}">
                                <button type="submit" class="btn btn-primary btn-sm">Contact Me</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
