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
            <a href="{{ route('materials.show', $material->id) }}" class="text-decoration-none">

                <div class="col" style="cursor: pointer">
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
                                <span class="badge" style="background-color:#cfe2ff; color:black; font-size:15px">
                                    <i class="fa-solid fa-file-lines" style="color: #3092fa;"></i>
                                    <span>{{ $material->file_count }}</span>
                                </span>
                                <span class="badge"
                                    style="background-color: {{ $material->materialType->color ?? '#ccc' }}">
                                    {{ $material->materialType->name ?? 'Unknown Type' }}
                                </span>
                            </p>

                            <div><i class="fa fa-user me-2"></i> <span>By, {{ $material->user->name }}</span></div>

                            <div>
                                <button type="button" class="btn btn-rounded w-100" style="background-color: #e2eaf7; color:#294f8d;"  data-mdb-ripple-init>+ Add to library</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
