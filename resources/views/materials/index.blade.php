@extends('new_layouts.app')
@section('page_name', 'Materials')
@section('page_description', 'This is post materials ..')
@section('styles')
    <style>
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

@section('content')

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

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3" id="myGrid">
        @foreach ($materials as $material)
            <div class="col">
                <div class="card border rounded-5">
                    <a href="{{ route('materials.show', $material->id) }}" class="text-decoration-none card-link">
                        <div class="card-body">
                            <!-- Report Dots -->
                            <div class="report-dots" title="Report this material">
                                <i class="fas fa-ellipsis-v"></i>
                                <!-- Dropdown Menu -->
                                <div class="dropdown-menu">
                                    <div class="dropdown-item" data-material-id="{{ $material->id }}" id="view-report">View
                                        Report</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <!-- Folder Icon and Name -->
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

                            <div style="color: #253c60; margin-bottom:0;"><i class="fa fa-user me-2"></i> <span>By,
                                    {{ $material->user->name }}</span></div>
                        </div>
                    </a>
                    <div class="card-footer">
                        <!-- Moved Date to Footer -->
                        <span class="date">{{ $material->created_at->format('Y-m-d') }}</span>
                        <button type="button" class="btn btn-rounded follow-button"
                            style="background-color: #e2eaf7; color:#2a2f5b;" data-material-id="{{ $material->id }}">
                            <i class="fa-solid {{ $material->is_followed ? 'fa-minus' : 'fa-plus' }}"></i>
                            {{ $material->is_followed ? 'Unsave' : 'Save' }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Report Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Report Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reportForm" method="POST" action="{{ route('user_report.submit') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="reportMaterialId" name="report_id">
                        <div class="mb-3">
                            <label for="reportReason" class="form-label">Reason</label>
                            <textarea class="form-control" id="reportReason" name="reason" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const followButtons = document.querySelectorAll('.follow-button');
            const reportDots = document.querySelectorAll('.report-dots');
            const dropdownMenus = document.querySelectorAll('.dropdown-menu');

            followButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.stopPropagation();
                    event.preventDefault();

                    const materialId = this.getAttribute('data-material-id');

                    this.blur();

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

                    const materialId = this.querySelector('.dropdown-item').getAttribute(
                        'data-material-id');
                    document.getElementById('reportMaterialId').value = materialId;

                    // Show the report modal
                    new bootstrap.Modal(document.getElementById('reportModal')).show();
                });
            });

            document.addEventListener('click', function(event) {
                if (!event.target.closest('.report-dots')) {
                    dropdownMenus.forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });
        });
    </script>
@endsection
