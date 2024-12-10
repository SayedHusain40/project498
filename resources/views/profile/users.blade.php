@extends('new_layouts.app')
@section('page_name', 'User Profile')
@section('page_description', 'Profile of the user')

@section('content')
    <section>
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 110px; height: 110px; background-color: #f0f0f0;">
                                    @if ($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image"
                                            class="img-fluid rounded-circle"
                                            style="width: 100px; height: 100px; object-fit: cover;">
                                    @else
                                        <i class="fas fa-user" style="font-size: 70px; color: #aaa;"></i>
                                    @endif
                                </div>
                            </div>
                            <h5 class="my-3">{{ $user->name }}</h5>
                            <p class="text-muted mb-1">Major: {{ $user->department->name ?? 'Not Specified' }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Full Name:</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->email }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Mobile</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->phone ?? 'Not Specified' }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Expertise At:</p>
                                </div>
                                <div class="col-sm-9">
                                    <ul class="list-unstyled">
                                        @if ($user->expertise->isEmpty())
                                            <li class="text-muted">Not Specified</li>
                                        @else
                                            @foreach ($user->expertise as $course)
                                                <li class="text-muted">{{ $course->name }} ({{ $course->code }})</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
