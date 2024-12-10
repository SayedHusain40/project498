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

        .hide {
            display: none;
        }

        .error {
            border-color: red;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h2>Enhance Your Profile</h2>

        <form id="profile-form" action="{{ route('additional-info.update', $user->id) }}" method="POST">
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

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="form-control" value="{{ $user->phone }}"
                    style="width: fit-content;">
                <span id="valid-msg" class="hide">✓ Valid</span>
                <span id="error-msg" class="hide"></span>
                @error('phone')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
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

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.querySelector("#phone");
            var form = document.querySelector("#profile-form");
            var errorMsg = document.querySelector("#error-msg");
            var validMsg = document.querySelector("#valid-msg");

            const iti = window.intlTelInput(input, {
                preferredCountries: ['bh',''], // Bahrain as the preferred country
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.9/js/utils.js" // For validation and formatting
            });

            // Reset validation messages
            const reset = () => {
                input.classList.remove("error");
                errorMsg.innerHTML = "";
                errorMsg.classList.add("hide");
                validMsg.classList.add("hide");
            };

            // Show error message
            const showError = (msg) => {
                input.classList.add("error");
                errorMsg.innerHTML = msg;
                errorMsg.classList.remove("hide");
            };

            // Form submission handler
            form.addEventListener('submit', function(event) {
                reset(); // Reset previous messages

                // Get the full phone number including country code
                const fullPhoneNumber = iti.getNumber();

                // Check if phone number is valid
                if (!fullPhoneNumber.trim()) {
                    showError("Phone number is required.");
                    event.preventDefault(); // Prevent form submission
                } else if (!iti.isValidNumber()) {
                    const errorCode = iti.getValidationError();
                    const errorMessages = [
                        "Invalid number",
                        "Invalid country code",
                        "Too short",
                        "Too long",
                        "Invalid number"
                    ];
                    const msg = errorMessages[errorCode] || "Invalid phone number";
                    showError(msg);
                    event.preventDefault(); // Prevent form submission
                } else {
                    // Set the input value to include the country code
                    input.value = fullPhoneNumber;
                }
            });

        });
    </script>
@endsection
