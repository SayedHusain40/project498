@extends('new_layouts.app')

@section('title', 'Dashboard')

@section('page_name', 'Dashboard')

@section('Rmsg')
    @if (session('registration_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Congratulations!</strong> Your registration was successful.
            <a href="{{ route('profile.info', auth()->user()->id) }}" style="text-decoration: underline !important">Enhance your profile</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endsection

@section('content')
    <!-- Welcome Message -->
<div class="row mb-4">
    <div class="col-12 text-center">
        @if(auth()->check())
            <!-- Logged-in User -->
            <h2 class="display-6 text-primary">
                👋 Welcome back, {{ auth()->user()->name }}! <br> Your study materials and others are ready to explore. 📚🚀
            </h2>
        @else
            <!-- Guest User -->
            <h2 class="display-5 text-primary">
                🌟 Welcome to our platform! <br> Log in to access study materials and others. 🎓📘
            </h2>
        @endif
    </div>
</div>




    <!-- Dashboard Section -->
    <div class="row">
        <!-- Number of Materials -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-primary me-3">
                        <i class="fa fa-folder"></i>
                    </span>
                    <div>
                        <h5 class="mb-1">
                            <b><a href="#"> {{ $materialCount }} <small>Materials</small></a></b>
                        </h5>
                        <small class="text-muted">Total materials in the system</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Number of Questions -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-info me-3">
                        <i class="fa fa-question-circle"></i>
                    </span>
                    <div>
                        <h5 class="mb-1">
                            <b><a href="#"> {{ $questionCount }} <small>Questions</small></a></b>
                        </h5>
                        <small class="text-muted">Total replies posted: {{ $replyCount }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Number of Users -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-success me-3">
                        <i class="fa fa-users"></i>
                    </span>
                    <div>
                        <h5 class="mb-1">
                            <b><a href="#"> {{ $userCount }} <small>Users</small></a></b>
                        </h5>
                        <small class="text-muted">Total users in the system</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Number of Events -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-warning me-3">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <div>
                        <h5 class="mb-1">
                            <b><a href="#"> {{ $eventCount }} <small>Events</small></a></b>
                        </h5>
                        <small class="text-muted">Total events in the system</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Number of Restaurants -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-danger me-3">
                        <i class="fa fa-utensils"></i>
                    </span>
                    <div>
                        <h5 class="mb-1">
                            <b><a href="#"> {{ $restaurantCount }} <small>Restaurants</small></a></b>
                        </h5>
                        <small class="text-muted">Total restaurants listed</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Number of Marketplaces -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-secondary me-3">
                        <i class="fa fa-store"></i>
                    </span>
                    <div>
                        <h5 class="mb-1">
                            <b><a href="#"> {{ $marketplaceCount }} <small>Marketplaces</small></a></b>
                        </h5>
                        <small class="text-muted">Total marketplace listings</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Number of Study Sessions -->
        <div class="col-sm-6 col-lg-3">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-primary me-3">
                        <i class="fa fa-book"></i>
                    </span>
                    <div>
                        <h5 class="mb-1">
                            <b><a href="#"> {{ $studySessionCount }} <small>Study Sessions</small></a></b>
                        </h5>
                        <small class="text-muted">Total study sessions we have</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection