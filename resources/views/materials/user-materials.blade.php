@extends('new_layouts.app')
@section('page_name', 'My Uploaded Materials')

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

        button:focus {
            outline: none;
            box-shadow: none;
        }

        button.follow-button:active {
            background-color: #e2eaf7;
            color: #2a2f5b;
        }

        button.btn.btn-danger.w-100.mt-2.delete-button {
            border-radius: 113px;
        }

        .modal-icon {
            font-size: 3rem;
            color: #dc3545;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-title {
            font-size: 1.25rem;
            margin-top: 1rem;
        }

        .modal-body p {
            font-size: 1rem;
            margin-top: 0.5rem;
        }
    </style>

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
                            {{ $material->is_followed ? 'Unsave' : 'Save' }}
                        </button>
                        <button type="button" class="btn btn-danger w-100 mt-2 delete-button"
                            data-material-id="{{ $material->id }}">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal for delete confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fa-solid fa-triangle-exclamation modal-icon"></i>
                    </div>
                    <h5 class="modal-title" id="deleteModalLabel">Delete Material</h5>
                    <p>Are you sure you want to delete this material?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger ms-2" id="confirmDelete">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const followButtons = document.querySelectorAll('.follow-button');
    const deleteButtons = document.querySelectorAll('.delete-button');
    let materialIdToDelete = null;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

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

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation();
            event.preventDefault();

            materialIdToDelete = this.getAttribute('data-material-id');
            deleteModal.show(); 
        });
    });

    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (materialIdToDelete) {
            fetch(`{{ route('materials.delete', '') }}/${materialIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const materialElement = document.querySelector(`[data-material-id="${materialIdToDelete}"]`).closest('.col');
                        if (materialElement) {
                            materialElement.remove();
                        }
                        deleteModal.hide(); // Hide the modal
                    } else {
                        alert('Failed to delete the material.');
                    }
                });
        }
    });
});

    </script>
@endsection
