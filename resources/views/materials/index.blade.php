@extends('new_layouts.app')
@section('page_name', 'Materials')
@section('page_description', 'This is post materials ..')
@section('styles')
    <style>
        button.btn-link:hover span {
            text-decoration: underline !important;
        }

        .btn:focus,
        .btn:hover {
            opacity: 1;
        }

        .card {
            position: relative;
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transform: scale(1.02);
        }

        .report-dots {
            position: absolute;
            top: 13px;
            right: 17px;
            cursor: pointer;
            color: #253c60;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 30px;
            /* Adjust position as needed */
            right: 0;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            padding: 10px 15px;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            text-align: center;
        }

        .date {
            font-size: 0.85rem;
            color: #888;
        }

        .folder-icon {
            font-size: 20px;
            color: #4caf50;
        }

        button:focus {
            outline: none;
            box-shadow: none;
        }

        button.follow-button:active {
            background-color: #e2eaf7;
            color: #2a2f5b;
        }
    </style>
@endsection
@php
    if (auth()->check()) {
        // If the user is logged in, check their role
        if (auth()->user()->role === 'user') {
            $role = 'user';
        }
    } else {
        $role = 'guest';
    }
@endphp
@section('content')

    <!-- Filter -->
    <div class="d-flex justify-content-between mb-4">
        <div class="d-flex">
            <form method="GET" action="{{ route('materials') }}" class="d-flex">
                <div class="input-group">
                    <select class="form-select me-2" name="course_code" id="course_code">
                        <option value="">All courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->code }}"
                                {{ request('course_code') == $course->code ? 'selected' : '' }}>
                                {{ $course->name }}-{{ $course->code }}
                            </option>
                        @endforeach
                    </select>
                    <select class="form-select me-2" name="material_type_id" id="material_type_id">
                        <option value="">All types</option>
                        @foreach ($materialTypes as $materialType)
                            <option value="{{ $materialType->id }}"
                                {{ request('material_type_id') == $materialType->id ? 'selected' : '' }}>
                                {{ $materialType->name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" type="submit">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Materials -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3" id="myGrid">
        @foreach ($materials as $material)
            <div class="col">
                <div class="card border rounded-5">
                    <a href="{{ route('materials.show', $material->id) }}" class="text-decoration-none card-link">
                        <div class="card-body">
                            <!-- Report Section -->
                            <div class="report-dots" title="Report this material">
                                <i class="fas fa-ellipsis-v"></i>
                                <div class="dropdown-menu">
                                    @if ($role === 'guest')
                                        <div style="color: red; padding:10px;" data-bs-toggle="modal"
                                            data-bs-target="#guestModal">Report</div>
                                    @else
                                        <div class="dropdown-item" style="color: red" data-bs-toggle="modal"
                                            data-bs-target="#reportModal" data-material-id="{{ $material->id }}"
                                            id="trigger-report-modal">Report</div>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>
                                    <i class="fas fa-folder folder-icon"></i>
                                    <span style="color: #2a2f5b">{{ $material->course->code }}</span>
                                </span>
                            </div>

                            <h4 class="card-title">{{ $material->title }}</h4>
                            <p>
                                <span class="badge rounded-pill" style="background-color:#cfe2ff; color:black;">
                                    <i class="fa-solid fa-file-lines" style="color: #3092fa;"></i>
                                    <span>{{ $material->file_count }}</span>
                                </span>
                                <span class="badge rounded-pill"
                                    style="background-color: {{ $material->materialType->color ?? '#ccc' }}">
                                    {{ $material->materialType->name ?? 'Unknown Type' }}
                                </span>
                            </p>

                            <!-- Date in the body now -->
                            <div class="date" style="color: #888;">
                                <i class="fa-solid fa-calendar me-2"></i>{{ $material->created_at->format('Y-m-d') }}
                            </div>
                        </div>
                    </a>
                    <div class="card-footer">
                        <div style="color: #253c60; display: flex; align-items: center;">
                            <form action="{{ route('users.profile') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $material->user->id }}">
                                <button type="submit" class="btn btn-link p-0"
                                    style="text-decoration: none !important; color: inherit; display: flex; align-items: center;">
                                    <i class="fa-solid fa-user-circle me-2"
                                        style="font-size: 24px; text-decoration: none !important;"></i>
                                    <span class="user-name">By, {{ $material->user->name }}</span>
                                </button>
                            </form>
                        </div>




                        <!-- Follow/Save Button -->
                        @if ($role === 'guest')
                            <button type="button" class="btn btn-rounded follow-button"
                                style="background-color: #e2eaf7; color:#2a2f5b;" data-bs-toggle="modal"
                                data-bs-target="#guestModal">
                                <i class="fa-solid fa-plus"></i> Save
                            </button>
                        @else
                            <button type="button" class="btn btn-rounded follow-button"
                                style="background-color: #e2eaf7; color:#2a2f5b;" data-material-id="{{ $material->id }}">
                                <i class="fa-solid {{ $material->is_followed ? 'fa-minus' : 'fa-plus' }}"></i>
                                {{ $material->is_followed ? 'Unsave' : 'Save' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
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




    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Report Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to report this material?</p>
                    <textarea id="reportReason" class="form-control" rows="4"
                        placeholder="Please provide a reason for reporting..."></textarea>
                    <input type="hidden" id="report_id" name="report_id">
                    <input type="hidden" id="report_type" name="report_type" value="material">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmReport">Report</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const followButtons = document.querySelectorAll('.follow-button');

            followButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const materialId = this.getAttribute('data-material-id');

                    fetch("{{ route('follow.toggle') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                material_id: materialId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            const icon = this.querySelector('i');
                            if (data.status === 'followed') {
                                icon.classList.remove('fa-plus');
                                icon.classList.add('fa-minus');
                                this.innerHTML = '<i class="fa-solid fa-minus"></i> Unsave';
                            } else if (data.status === 'unfollowed') {
                                icon.classList.remove('fa-minus');
                                icon.classList.add('fa-plus');
                                this.innerHTML = '<i class="fa-solid fa-plus"></i> Save';
                            }
                        });
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reportDots = document.querySelectorAll('.report-dots');
            const dropdownMenus = document.querySelectorAll('.dropdown-menu');
            const reportModalElement = document.getElementById('reportModal');
            const reportModal = new bootstrap.Modal(reportModalElement);

            reportDots.forEach(dot => {
                dot.addEventListener('click', function(event) {
                    event.stopPropagation();
                    event.preventDefault();

                    const dropdownMenu = this.querySelector('.dropdown-menu');
                    dropdownMenu.classList.toggle('show');

                    // Hide other open dropdown menus
                    dropdownMenus.forEach(menu => {
                        if (menu !== dropdownMenu) {
                            menu.classList.remove('show');
                        }
                    });
                });
            });

            const reportOptions = document.querySelectorAll('.dropdown-item');
            reportOptions.forEach(option => {
                option.addEventListener('click', function(event) {
                    if (this.textContent.trim() === 'Log Out') {
                        return;
                    }

                    const materialId = this.getAttribute('data-material-id');
                    document.getElementById('report_id').value = materialId;
                    document.getElementById('report_type').value = 'material';

                    reportModal.show();
                });
            });

            // document.addEventListener('click', function(event) {
            //     dropdownMenus.forEach(menu => {
            //         if (!event.target.closest('.report-dots')) {
            //             menu.classList.remove('show');
            //         }
            //     });
            // });

            document.getElementById('confirmReport').addEventListener('click', function() {
                const reportId = document.getElementById('report_id').value;
                const reportType = document.getElementById('report_type').value;
                const reason = document.getElementById('reportReason').value;

                fetch('{{ route('user_report.submit') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            report_id: reportId,
                            report_type: reportType,
                            reason: reason
                        })
                    })
                    .then(() => {
                        // Clear the textarea after successful submission
                        document.getElementById('reportReason').value = '';

                        reportModal.hide();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        reportModal.hide();
                    });
            });
        });
    </script>

@endsection
