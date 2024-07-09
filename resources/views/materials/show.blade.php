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

        .badge-file-extension {
            background-color: #f25961;
            color: white;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            margin-left: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h1>Title: {{ $material->title }}</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-striped custom-table">
            <thead>
                <tr>
                    <th scope="col">Bookmarks</th>
                    <th scope="col">Document</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                    <tr>
                        <td>
                            <button type="button" class="btn btn-outline-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bookmarks" viewBox="0 0 16 16">
                                    <path
                                        d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1z">
                                    </path>
                                    <path
                                        d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1">
                                    </path>
                                </svg>
                                <span class="visually-hidden">Button</span>
                            </button>
                        </td>
                        <td>
                            <div>
                                @php
                                    $extension = pathinfo($file->name, PATHINFO_EXTENSION);
                                @endphp
                                <i class="fa-solid fa-file-lines" style="color: #0068b8; margin-right: 5px;"></i> <a
                                    href="{{ Storage::url($file->path) }}" target="_blank">
                                    {{ pathinfo($file->name, PATHINFO_FILENAME) }}


                                </a>
                                <span>
                                    <span class="badge badge-file-extension">
                                        {{ strtoupper($extension) }} File
                                    </span>
                                </span>
                            </div>

                        </td>
                        <td>
                            <a class="btn btn-primary rounded-pill" href="{{ Storage::url($file->path) }}" download>
                                <i class="fas fa-download me-1"></i> Download
                            </a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
