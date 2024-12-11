@extends('new_layouts.app')

@section('title', 'Dashboard')

{{-- @section('page_name', 'Dashboard') --}}

@section('Rmsg')
    @if (session('registration_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Congratulations!</strong> Your registration was successful.
            <a href="{{ route('profile.info', auth()->user()->id) }}" style="text-decoration: underline !important">Enhance
                your profile</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endsection

@section('content')
    <!-- Welcome Message
    <div class="row mb-4">
        <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-center">
             Message on the left
            <div class="col-12 col-md-6 text-start" style="color:#1a2035"> -->
                @if (auth()->check())
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h2>
                            Welcome back, {{ auth()->user()->name }}! <br>
                            Your study materials and others are ready to explore.
                        </h2>
                    </div>
                </div>
            @else
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h2>
                             Welcome to our platform! <br>
                            Log in to access study materials and others.
                        </h2>
                    </div>
                </div>
            @endif

           <!-- </div>

             Image on the right
            <div class="col-12 col-md-6 text-end">
                <img src="{{ asset('images/o3.png') }}" alt="Image" class="img-fluid"
                    style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div> -->



    <div class="row">
        <!-- Number of Materials -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <a href="{{ route('materials') }}" class="text-dark text-decoration-none">
                    <div class="d-flex align-items-center">
                        <span class="stamp stamp-md bg-primary me-3">
                            <i class="fa fa-folder"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">
                                <b>{{ $materialCount }} <small>Materials</small></b>
                            </h5>
                            <small class="text-muted">Total materials in the system</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Number of Questions -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <a href="{{ route('chats.index') }}" class="text-dark text-decoration-none">
                    <div class="d-flex align-items-center">
                        <span class="stamp stamp-md bg-info me-3">
                            <i class="fa fa-question-circle"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">
                                <b>{{ $questionCount }} <small>Questions</small></b>
                            </h5>
                            <small class="text-muted">Total replies posted: {{ $replyCount }}</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Number of Users -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <a href="#" class="text-dark text-decoration-none">
                    <div class="d-flex align-items-center">
                        <span class="stamp stamp-md bg-success me-3">
                            <i class="fa fa-users"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">
                                <b>{{ $userCount }} <small>Users</small></b>
                            </h5>
                            <small class="text-muted">Total users in the system</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Number of Events -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <a href="{{ route('announcements.index') }}" class="text-dark text-decoration-none">
                    <div class="d-flex align-items-center">
                        <span class="stamp stamp-md bg-warning me-3">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">
                                <b>{{ $eventCount }} <small>Events</small></b>
                            </h5>
                            <small class="text-muted">Total events in the system</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Number of Restaurants -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <a href="{{ route('restaurants.index') }}" class="text-dark text-decoration-none">
                    <div class="d-flex align-items-center">
                        <span class="stamp stamp-md bg-danger me-3">
                            <i class="fa fa-utensils"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">
                                <b>{{ $restaurantCount }} <small>Restaurants</small></b>
                            </h5>
                            <small class="text-muted">Total restaurants listed</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Number of Marketplaces -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <a href="{{ route('marketplace') }}" class="text-dark text-decoration-none">
                    <div class="d-flex align-items-center">
                        <span class="stamp stamp-md bg-secondary me-3">
                            <i class="fa fa-store"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">
                                <b>{{ $marketplaceCount }} <small>Items</small></b>
                            </h5>
                            <small class="text-muted">Total marketplace listings</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Number of Study Sessions -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <a href="{{ route('study-sessions.index') }}" class="text-dark text-decoration-none">
                    <div class="d-flex align-items-center">
                        <span class="stamp stamp-md bg-primary me-3">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">
                                <b>{{ $studySessionCount }} <small>Study Sessions</small></b>
                            </h5>
                            <small class="text-muted">Total study sessions we have</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Number of Clubs -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <a href="{{ route('clubs.index') }}" class="text-dark text-decoration-none">
                    <div class="d-flex align-items-center">
                        <span class="stamp stamp-md bg-dark me-3">
                            <i class="fa fa-users-cog"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">
                                <b>{{ $clubCount }} <small>Clubs</small></b>
                            </h5>
                            <small class="text-muted">Total clubs available</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
