@extends('new_layouts.app')
@section('page_name', 'Materials')
@section('page_description', 'This is post materials ..')

@section('content')
    <style>
        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
        }

        .card {
            transition: all 0.3s ease-in-out;
        }
    </style>

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
                            <div class="d-flex justify-content-between mb-3">
                                <span><i class="fas fa-folder mr-10px" style="font-size: 20px; color:#4caf50"></i>
                                    <span style="color: #2a2f5b">{{ $material->course->code }}</span></span>
                                <span class="text-muted">{{ $material->created_at->format('Y-m-d') }}</span>
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
                        <button type="button" class="btn btn-rounded w-100 follow-button"
                            style="background-color: #e2eaf7; color:#2a2f5b;" data-material-id="{{ $material->id }}">
                            <i class="fa-solid {{ $material->is_followed ? 'fa-minus' : 'fa-plus' }}"></i>
                            {{ $material->is_followed ? 'Unfollow' : 'Follow' }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const followButtons = document.querySelectorAll('.follow-button');

            followButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.stopPropagation();
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
                                this.innerHTML = '<i class="fa-solid fa-minus"></i> Unfollow';
                            } else if (data.status === 'unfollowed') {
                                icon.classList.remove('fa-minus');
                                icon.classList.add('fa-plus');
                                this.innerHTML = '<i class="fa-solid fa-plus"></i> Follow';
                            }
                        });
                });
            });
        });
    </script>
@endsection
