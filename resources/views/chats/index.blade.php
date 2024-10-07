@extends('new_layouts.app')

@section('title', 'Chats')
@section('page_name', 'Chat Departments')

@section('content')
    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($departments as $department)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('images/qa.png') }}" class="d-block mx-auto w-50">
                        <div class="card-body pb-0">
                            <h5 class="card-title">{{ $department->name }} Chat</h5>
                            <p class="card-text">Join the conversation in the {{ $department->name }} department. Stay updated with all the latest discussions!</p>
                            <a href="{{ route('chats.department', $department->id) }}" class="btn btn-primary ">Go to Chat</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
