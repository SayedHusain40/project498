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
                            <i class="fas fa-user-circle fa-7x" style="color: #007bff;"></i>
                            <h5 class="my-3">{{ $user->name }}</h5>
                            <p class="text-muted mb-1">{{ $user->department->name ?? 'Not Specified' }}</p>
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
                                    <p class="text-muted mb-0">{{ $user->mobile ?? 'Not Specified' }}</p>
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
