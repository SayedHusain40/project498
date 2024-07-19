@extends('new_layouts.app')
@section('page_name', 'Bookmarked Files')
@section('page_description', 'Your bookmarked files.')

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

        .bookmark-active svg {
            fill: #FF9800; 
        }
    </style>
@endsection

@section('content')

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
                @foreach ($bookmarks as $bookmark)
                    <tr>
                        <td>
                            @php
                                $isBookmarked = true; 
                            @endphp
                            <button type="button" class="btn btn-outline-dark bookmark-toggle bookmark-active" data-file-id="{{ $bookmark->file->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bookmarks-fill" viewBox="0 0 16 16">
                                    <path d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5z"/>
                                    <path d="M4.268 1A2 2 0 0 1 6 0h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L13 13.768V2a1 1 0 0 0-1-1z"/>
                                </svg>
                                <span class="visually-hidden">Button</span>
                            </button>
                        </td>
                        <td>
                            <div>
                                @php
                                    $extension = pathinfo($bookmark->file->name, PATHINFO_EXTENSION);
                                @endphp
                                <i class="fa-solid fa-file-lines" style="color: #0068b8; margin-right: 5px;"></i> <a
                                    href="{{ Storage::url($bookmark->file->path) }}" target="_blank">
                                    {{ pathinfo($bookmark->file->name, PATHINFO_FILENAME) }}
                                </a>
                                <span>
                                    <span class="badge badge-file-extension">
                                        {{ strtoupper($extension) }} File
                                    </span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <a class="btn btn-primary rounded-pill" href="{{ Storage::url($bookmark->file->path) }}" download>
                                <i class="fas fa-download me-1"></i> Download
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.bookmark-toggle').forEach(function (button) {
                button.addEventListener('click', function () {
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
                        if (data.status === 'removed') {
                            button.closest('tr').remove(); 
                        } else if (data.status === 'added') {
                            button.classList.add('bookmark-active');
                            button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bookmarks-fill" viewBox="0 0 16 16">
                                        <path d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5z"/>
                                        <path d="M4.268 1A2 2 0 0 1 6 0h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L13 13.768V2a1 1 0 0 0-1-1z"/>
                                    </svg>`;
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection
