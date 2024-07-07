@extends('new_layouts.app')
@section('page_name', 'Material Files')
@section('page_description', 'Files for the selected material.')

@section('styles')
    <style>
        .custom-table {
            border-collapse: collapse;
            border-radius: 20px;
            border-style: hidden;
            box-shadow: 0 0 0 1px #e6ebef;
            overflow: hidden;
            text-align: left;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h1>{{ $material->title }}</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-striped custom-table">
            <thead>
                <tr>
                    <th scope="col">Document</th>
                    <th scope="col">File Type</th>
                    <th scope="col">Ratings</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                    <tr>
                        <td>
                            @php
                                $extension = pathinfo($file->name, PATHINFO_EXTENSION);
                                $isPdf = strtolower($extension) === 'pdf';
                            @endphp
                            @if ($isPdf)
                                <i class="fas fa-file-pdf" style="color: #d62728;"></i>
                            @else
                                <i class="fas fa-file" style="color: #3092fa;"></i>
                            @endif
                            <a href="{{ Storage::url($file->path) }}" target="_blank">
                                {{ pathinfo($file->name, PATHINFO_FILENAME) }}
                            </a>
                        </td>
                        <td>{{ strtoupper($extension) }}</td>
                        <td>
                            <span class="badge bg-success">{{ $file->rating }}% ({{ $file->rating_count }})</span>
                        </td>
                        <td>
                            <a class="btn btn-primary rounded-pill" href="{{ Storage::url($file->path) }}" download>Download</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
