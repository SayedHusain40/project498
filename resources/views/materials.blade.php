@extends('new_layouts.app')
@section('page_name', 'Materials')
@section('page_description', 'This is post materials ..')

@section('content')

    <div class="d-flex justify-content-between mb-4">
        <div class="d-flex">
            <form method="GET" action="{{ route('materials') }}" class="d-flex">
                <div class="input-group">
                    <select class="form-select" name="course_code" id="course_code">
                        <option value="">All courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->code }}"
                                {{ request('course_code') == $course->code ? 'selected' : '' }}>
                                {{ $course->code }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary ms-2" type="submit">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4" id="myGrid">
        @foreach ($materials as $material)
            <div class="col mb-3">
                <div class="card border rounded-5">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span><i class="fas fa-folder mr-10px" style="font-size: 20px; color:#4caf50"></i>
                                <span>{{ $material->course->code }}</span></span>
                            <span class="text-muted">{{ $material->created_at->format('Y-m-d') }}</span>
                        </div>

                        <h4 class="card-title">{{ $material->title }}</h4>
                        <p class="card-text">{{ $material->description }}</p>
                        <p><i class="fa-solid fa-file-lines" style="color:#ef5350"></i>
                            <span>{{ $material->file_count }}</span>
                        </p>

                        <div><i class="fa fa-user me-2"></i> <span>{{ $material->user->name }}</span></div>

                        <div>
                            <a href="#" class="btn btn-label-info btn-round me-2 w-100">+ Add to my library</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
