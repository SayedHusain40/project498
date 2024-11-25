@extends('new_layouts.app')

@section('title', 'Home Page')

@section('page_name', 'Homepage')

@section('page_description', 'this is home page ..')

@section('Rmsg')
    @if (session('registration_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Congratulations!</strong> Your registration was successful.
            <a href="{{ route('profile.info', auth()->user()->id) }}" style="text-decoration: underline !important">Enhance your
                profile</a>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endsection
@section('content')
    <div class="row row-card-no-pd">
        <div style="font-size: 20px">
            Content
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Quote
        </div>
        <div class="card-body">
            <blockquote class="blockquote mb-0">
            <p>"The more I read, the more I acquire, the more certain I am that I know nothing."</p>
            <footer class="blockquote-footer">Voltaire</footer>
            </blockquote>
        </div>
    </div>
@endsection
