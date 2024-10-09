@extends('new_layouts.app')
@section('styles')
    <style>
        .modal-icon {
            font-size: 3rem;
            color: #dc3545;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-title {
            font-size: 1.25rem;
            margin-top: 1rem;
        }

        .modal-body p {
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        .custom-table {
            border-collapse: collapse;
            border-radius: 1rem;
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

        .bookmark-active svg {
            fill: #FF9800;
        }

        .description-text {
            font-size: 1.1rem;
            color: #555;
            margin-top: 0.5rem;
        }

        .comment {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .comment-section {
            border: 1px solid #e9ebee;
            border-radius: 1rem;
            padding: 1.5rem;
            background-color: #ffffff;
            /* box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1); */
        }

        .comment-header {
            border-bottom: 1px solid #e9ebee;
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
        }

        .comment-avatar {
            height: 48px;
            width: 48px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .comment-author {
            font-size: 1rem;
            font-weight: 600;
        }

        .comment-time {
            font-size: 0.875rem;
            color: #90949c;
        }

        .comment-body {
            margin: 0.75rem 0;
            font-size: 1rem;
        }

        .comment-actions a {
            font-size: 0.875rem;
            color: #4267b2;
            text-decoration: none;
            margin-right: 1rem;
        }

        .comment-actions i {
            margin-right: 0.5rem;
        }

        .reply-list {
            margin-top: 1rem;
            padding-left: 2rem;
        }

        .reply-list .comment {
            border-left: 1px dotted #d3d6db;
            padding-left: 1rem;
            margin-top: 1rem;
        }

        .reply-toggle {
            cursor: pointer;
            font-size: 0.875rem;
            color: #4267b2;
            text-decoration: none;
            margin-top: 1rem;
            display: block;
        }

        .reply-form {
            display: none;
            position: relative;
            z-index: 10;
        }

        .comment-input {
            border-radius: 0.5rem;
        }

        .like-button.active i {
            color: #4caf50;
        }

        .dislike-button.active i {
            color: #dc3545;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-menu {
            right: 0;
            left: auto;
        }
    </style>
@endsection
@php
    if (auth()->check()) {
        if (auth()->user()->role === 'user') {
            $role = 'user';
        }  
    } else {
        $role = 'guest'; 
    }
@endphp

@section('content')
    <div>
        <div class="d-flex flex-column">
            <h1>Title: {{ $material->title }}</h1>
            @if ($material->description)
                <p class="description-text"><strong>Description:</strong> {{ $material->description }}</p>
            @endif
        </div>

        <div class="d-flex justify-content-end mb-4">
            @if ($role === 'guest')
                <button type="button" class="btn rounded-3" style="background-color: #4CAF50; color: white" data-bs-toggle="modal" data-bs-target="#guestModal">
                    <i class="fas fa-download me-1"></i> Download All
                </button>
            @else
                <a class="btn rounded-3" style="background-color: #4CAF50; color: white" href="{{ route('materials.downloadAll', $material) }}">
                    <i class="fas fa-download me-1"></i> Download All
                </a>
            @endif
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
                                @php
                                    $isBookmarked = $file->bookmarks()->where('user_id', Auth::id())->exists();
                                @endphp
                                @if ($role === 'guest')
                                    <button type="button" class="btn btn-outline-dark bookmark-toggle" data-bs-toggle="modal" data-bs-target="#guestModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmarks" viewBox="0 0 16 16">
                                            <path d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1z"/>
                                            <path d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1"/>
                                        </svg>
                                        <span class="visually-hidden">Button</span>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-outline-dark bookmark-toggle {{ $isBookmarked ? 'bookmark-active' : '' }}" data-file-id="{{ $file->id }}">
                                        @if ($isBookmarked)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmarks-fill" viewBox="0 0 16 16">
                                                <path d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5z"/>
                                                <path d="M4.268 1A2 2 0 0 1 6 0h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L13 13.768V2a1 1 0 0 0-1-1z"/>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmarks" viewBox="0 0 16 16">
                                                <path d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1z"/>
                                                <path d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1"/>
                                            </svg>
                                        @endif
                                        <span class="visually-hidden">Button</span>
                                    </button>
                                @endif
                            </td>
                            <td>
                                <div>
                                    @php
                                        $extension = pathinfo($file->name, PATHINFO_EXTENSION);
                                    @endphp
                                    <i class="fa-solid fa-file-lines" style="color: #0068b8; margin-right: 5px;"></i>
                                    <a href="{{ Storage::url($file->path) }}" target="_blank">
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
                                @if ($role === 'guest')
                                    <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#guestModal">
                                        <i class="fas fa-download me-1"></i> Download
                                    </button>
                                @else
                                    <a class="btn btn-primary rounded-pill" href="{{ route('files.download', $file) }}">
                                        <i class="fas fa-download me-1"></i> Download
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Guest User Modal -->
    <div class="modal fade" id="guestModal" tabindex="-1" aria-labelledby="guestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="guestModalLabel">Login Required</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    You need to be logged in to perform this action. Please log in or sign up to continue.
                </div>
                <div class="modal-footer">
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.bookmark-toggle').forEach(function(button) {
                button.addEventListener('click', function() {
                    const fileId = this.getAttribute('data-file-id');
                    const button = this;

                    fetch("{{ route('bookmark.toggle') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                file_id: fileId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'added') {
                                button.classList.add('bookmark-active');
                                button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bookmarks-fill" viewBox="0 0 16 16">
                                        <path d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5z"/>
                                        <path d="M4.268 1A2 2 0 0 1 6 0h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L13 13.768V2a1 1 0 0 0-1-1z"/>
                                    </svg>`;
                            } else if (data.status === 'removed') {
                                button.classList.remove('bookmark-active');
                                button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bookmarks" viewBox="0 0 16 16">
                                        <path d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1z"/>
                                        <path d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1"/>
                                    </svg>`;
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection