@extends('new_layouts.app')
@section('page_name', 'Material Files')
@section('page_description', 'Files for the selected material.')

@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h1>{{ $material->title }}</h1>
    </div>

    <div class="row">
        @foreach ($files as $file)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$file->name }}</h5>
                        <a href="#" class="btn btn-primary">View File</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
