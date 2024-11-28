@extends('new_layouts.app')
@section('page_name', 'All Upcoming Study Sessions')

@section('button_url')
    {{ route('study-sessions.create') }}
@endsection

@section('button_label')
    Post Study Sessions
@endsection
@section('content')
    <!-- if there are not porducts-->
    @if ($studySessions->isEmpty())
        <div class="text-center">
            <p>No products available at the moment. Please check back later.</p>
        </div>
    @else
        <div class="container mt-4">

            <div class="row">
                @foreach ($studySessions as $session)
                    <div class="col-12 mb-4">
                        <div class="d-flex rounded-xl shadow-sm" style="height: 200px; background-color: #ffffff;">
                            <div class="bg-primary text-white p-3 rounded-start"
                                style="width: 200px; border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;">
                                <p class="text-muted text-uppercase" style="font-size: 12px;">Course</p>
                                <h2 class="font-weight-bold" style="font-size: 18px;">{{ $session->course->name }}</h2>
                            </div>

                            <div class="p-3 bg-light rounded-end w-100 position-relative"
                                style="border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem;">
                                <h3 class="mt-1" style="font-weight: 500; font-size: 15px;"><b>Topic:</b>
                                    {{ $session->topic }}</h3>
                                <h3 class="mt-1" style="font-weight: 500; font-size: 15px;"><b>Description:</b>
                                    {{ $session->description }}</h3>

                                <p class="card-text"><strong>Date:</strong>
                                    {{ \Carbon\Carbon::parse($session->session_date)->format('F j, Y h:i A') }}</p>
                                <p class="mt-1" style="font-size: 14px;"><strong>Location:</strong>
                                    {{ $session->location }}
                                </p>
                                <p class="mt-1" style="font-size: 14px;">
                                    <strong>Price: </strong>
                                    @if ($session->price_or_volunteer === 'price')
                                        BD {{ number_format($session->price, 3) }}
                                    @else
                                        Volunteer
                                    @endif
                                </p>

                                <form action="{{ route('users.profile') }}" method="POST" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $session->user->id }}">
                                    <button type="submit" class="btn btn-primary rounded-3 position-absolute"
                                        style="right: 10px; bottom: 10px;">Contact Me</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
