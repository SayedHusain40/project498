@extends('new_layouts.app')

@section('page_name', 'Followed Materials')
@section('page_description', 'Materials you are saving.')
@section('styles')
    <style>
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
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3" id="myGrid">
        @foreach ($followedMaterials as $material)
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
                    const card = this.closest('.col');

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
                                // Remove the material card 
                                card.remove();
                            }
                        });
                });
            });
        });
    </script>
@endsection
