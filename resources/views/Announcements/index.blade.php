@extends('new_layouts.app')

@section('page_name', 'Upcoming Events')

@section('button_url')
    {{ route('announcements.create') }}
@endsection

@section('button_label')
    Post Event
@endsection

@section('content')
    <!-- Check if there are no announcements -->
    @if ($announcements->isEmpty())
        <div class="text-center">
            <p>No Events available at the moment. Please check back later.</p>
        </div>
    @else
        <div class="container mt-4">
            <div class="row">
                @foreach ($announcements as $announcement)
                    <div class="col-12 mb-4">
                        <div class="d-flex rounded-xl shadow-sm" style="height: 200px; background-color: #ffffff;">
                            <div class="bg-primary text-white p-3 rounded-start"
                                style="width: 200px; border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;">
                                <p class="text-muted text-uppercase" style="font-size: 12px;">Category</p>
                                <h2 class="font-weight-bold" style="font-size: 18px;">{{ $announcement->category }}</h2>
                            </div>

                            <div class="p-3 bg-light rounded-end w-100 position-relative"
                                style="border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem;">
                                <h3 class="mt-1" style="font-weight: 500; font-size: 15px;"><b>Title:</b>
                                    {{ $announcement->title }}</h3>
                                <h3 class="mt-1" style="font-weight: 500; font-size: 15px;"><b>Description:</b>
                                    {{ $announcement->description }}</h3>

                                <p class="card-text"><strong>Date:</strong>
                                    {{ \Carbon\Carbon::parse($announcement->event_date)->format('F j, Y h:i A') }}</p>
                                <p class="mt-1" style="font-size: 14px;"><strong>Location:</strong>
                                    {{ $announcement->location }}
                                </p>

                                <form action="{{ route('users.profile') }}" method="POST" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $announcement->user->id }}">
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
