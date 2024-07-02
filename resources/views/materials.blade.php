@extends('new_layouts.app')
@section('page_name', 'Materials')
@section('page_description', 'This is post materials ..')

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
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span><i class="fas fa-folder mr-10px" style="font-size: 20px; color:#4caf50"></i>
                                <span>{{ $material->course->code }}</span></span>
                            <span class="text-muted">{{ $material->created_at->format('Y-m-d') }}</span>
                        </div>

                        <h4 class="card-title">{{ $material->title }}</h4>
                        <p class="card-text">{{ $material->description }}</p>

                        <p>
                            <span class="badge" style="background-color:#cfe2ff; color:#ef5350"><i
                                    class="fa-solid fa-file-lines"></i>
                                <span>{{ $material->file_count }}</span>
                            </span>
                            <span class="badge" style="background-color: {{ $material->materialType->color ?? '#ccc' }}">
                                {{ $material->materialType->name ?? 'Unknown Type' }}
                            </span>
                        </p>

                        <div><i class="fa fa-user me-2"></i> <span>By, {{ $material->user->name }}</span></div>

                        <div>
                            <button class="btn btn-primary btn-border btn-round mt-1 w-100">+ Add to library</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
