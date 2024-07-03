@extends('new_layouts.app')

@section('title', 'Upload Page')

@section('page_name', 'Upload')

@section('page_description', 'This is the Upload page.')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <form method="post" action="/up" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Upload Form</h5>

                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title') }}" placeholder="Enter title">
                                @error('title')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="material_type_id" class="form-label">Material Type:</label>
                                <select class="form-select" id="material_type_id" name="material_type_id">
                                    <option value="">Select a material type</option>
                                    @foreach ($materialTypes as $materialType)
                                        <option value="{{ $materialType->id }}"
                                            {{ old('material_type_id') == $materialType->id ? 'selected' : '' }}>
                                            {{ $materialType->name }}</option>
                                    @endforeach
                                </select>
                                @error('material_type_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex align-items-end">
                                <div class="me-3 flex-grow-1">
                                    <label for="college" class="form-label">College:</label>
                                    <select class="form-select" id="college" name="college">
                                        <option value="">Select a college</option>
                                        @foreach ($colleges as $college)
                                            <option value="{{ $college->id }}">{{ $college->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="me-3 flex-grow-1">
                                    <label for="department" class="form-label">Department:</label>
                                    <select class="form-select" id="department" name="department" disabled>
                                        <option value="">Select a department</option>
                                    </select>
                                </div>
                                <div class="flex-grow-1">
                                    <label for="course_id" class="form-label">Course:</label>
                                    <select class="form-select" id="course_id" name="course_id" disabled>
                                        <option value="">Select a course</option>
                                    </select>
                                </div>
                            </div>
                            @error('course_id')
                                <p class="text-danger">The course is required.</p>
                            @enderror

                            <!-- FilePond input -->
                            <div class="mb-3">
                                <input type="file" class="filepond" name="file" multiple credits="false">
                            </div>
                            @error('file')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror

                            <div class="mt-4">
                                <button type="submit"
                                    class="btn btn-primary w-100 py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colleges = @json($colleges);
            const collegeSelect = document.getElementById('college');
            const departmentSelect = document.getElementById('department');
            const courseSelect = document.getElementById('course_id');

            collegeSelect.addEventListener('change', function() {
                const selectedCollegeId = this.value;

                departmentSelect.innerHTML = '<option value="">Select a department</option>';
                courseSelect.innerHTML = '<option value="">Select a course</option>';
                courseSelect.disabled = true;

                if (selectedCollegeId) {
                    departmentSelect.disabled = false;
                    const selectedCollege = colleges.find(college => college.id == selectedCollegeId);
                    selectedCollege.departments.forEach(department => {
                        const option = document.createElement('option');
                        option.value = department.id;
                        option.textContent = department.name;
                        departmentSelect.appendChild(option);
                    });
                } else {
                    departmentSelect.disabled = true;
                }
            });

            departmentSelect.addEventListener('change', function() {
                const selectedDepartmentId = this.value;

                courseSelect.innerHTML = '<option value="">Select a course</option>';

                if (selectedDepartmentId) {
                    courseSelect.disabled = false;
                    const selectedCollege = colleges.find(college => college.id == collegeSelect.value);
                    const selectedDepartment = selectedCollege.departments.find(department => department
                        .id == selectedDepartmentId);
                    selectedDepartment.courses.forEach(course => {
                        const option = document.createElement('option');
                        option.value = course.id;
                        option.textContent = `${course.code} - ${course.name}`;
                        courseSelect.appendChild(option);
                    });
                } else {
                    courseSelect.disabled = true;
                }
            });
        });
    </script>
@endsection
