@extends('new_layouts.app')

@section('styles')
    <style>
        .checkbox-wrapper-16 {
            margin-bottom: 1rem;
        }

        .checkbox-wrapper-16 .checkbox-label {
            color: #707070;
            transition: 0.375s ease;
            text-align: center;
            margin-top: 0.5rem;
        }

        .checkbox-wrapper-16 .checkbox-tile {
            transition: 0.15s ease;
        }

        .checkbox-wrapper-16:hover .checkbox-tile {
            border-color: #2260ff;
        }

        .checkbox-wrapper-16 .checkbox-input:checked+.checkbox-tile .checkbox-label {
            color: #2260ff;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h2>Enhance Your Profile</h2>

        <form action="{{ route('additional-info.update', $user->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="major" class="form-label">Major</label>
                <select id="major" name="major_id" class="form-select" style="width: auto;">
                    <option value="">Select Major</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ $user->major_id == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>



            <div class="mt-4">
                <label class="form-label">Select Courses You Are Expertise At:</label>
                <div class="row g-2">
                    @foreach ($courses as $course)
                        <div class="col-5 col-md-4 col-lg-3">
                            <div class="card checkbox-wrapper-16">
                                <div class="card-body text-center">
                                    <input class="checkbox-input" type="checkbox" name="course_ids[]"
                                        value="{{ $course->id }}"
                                        {{ $user->expertise->contains($course->id) ? 'checked' : '' }}>
                                    <span class="checkbox-tile" style="width: fit-content">
                                        <span class="checkbox-label"> {{ $course->code }} | {{ $course->name }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Update</button>
        </form>
    </div>
@endsection
