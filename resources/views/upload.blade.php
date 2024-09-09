@extends('new_layouts.app')

@section('title', 'Upload Page')

@section('page_name', 'Upload')

@section('page_description', 'This is the Upload page.')


@section('styles')
    <style>
        .dropdown-menu {
            background-color: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .dropdown-item {
            color: #000000;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
            border-radius: 0.25rem;
            border: 1px solid rgba(0, 0, 0, 0.125);
            display: none;
            position: absolute;
            background-color: #ffffff;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }

        .dropdown-menu.show {
            display: block;
        }

        .btn-light {

            border-color: #E0E0E0;
            border-radius: 7px;
        }
    </style>
@endsection

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

                            <div class="mb-3">
                                <label for="course" class="form-label">Course:</label>
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle" type="button" id="courseDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Select a course
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="courseDropdown">
                                        @foreach ($colleges as $college)
                                            <li class="dropdown-submenu">
                                                <a class="dropdown-item dropdown-toggle"
                                                    href="#">{{ $college->name }}</a>
                                                <ul class="dropdown-menu">
                                                    @foreach ($college->departments as $department)
                                                        <li class="dropdown-submenu">
                                                            <a class="dropdown-item dropdown-toggle"
                                                                href="#">{{ $department->name }}</a>
                                                            <ul class="dropdown-menu">
                                                                @foreach ($department->courses as $course)
                                                                    <li>
                                                                        <a class="dropdown-item" href="#"
                                                                            data-course-id="{{ $course->id }}">
                                                                            {{ $course->code }} - {{ $course->name }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="course_id" name="course_id">
                                @error('course_id')
                                    <p class="text-danger">The course is required.</p>
                                @enderror
                            </div>

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
            const courseDropdownItems = document.querySelectorAll('.dropdown-menu .dropdown-item');
            const courseDropdown = document.getElementById('courseDropdown');
            const courseIdInput = document.getElementById('course_id');

            courseDropdownItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent default action
                    e.stopPropagation(); // Stop event from bubbling up

                    const courseId = this.getAttribute('data-course-id');
                    if (courseId) {
                        courseIdInput.value = courseId;
                        courseDropdown.innerText = this.innerText;

                        // Hide the dropdown menu
                        const dropdown = new bootstrap.Dropdown(courseDropdown);
                        dropdown.hide();
                    }
                });
            });

            // Optional: Add logic to show/hide submenus on hover
            document.querySelectorAll('.dropdown-submenu .dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('mouseover', function() {
                    this.nextElementSibling.classList.add('show');
                });
                toggle.addEventListener('mouseout', function() {
                    this.nextElementSibling.classList.remove('show');
                });
            });
        });
    </script>
@endsection

