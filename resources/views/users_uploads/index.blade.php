@extends('new_layouts.app')
@section('page_name', 'My Uploaded')
@section('styles')
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

        .nav-pills .nav-link:hover {
            color: #253c60;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <ul class="nav nav-tabs nav-line nav-color-secondary mb-4" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-materials-tab" data-bs-toggle="pill" data-bs-target="#pills-materials"
                    href="#" role="tab" aria-controls="pills-materials" aria-selected="true">Materials</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-marketplace-tab" data-bs-toggle="pill" data-bs-target="#pills-marketplace"
                    href="#" role="tab" aria-controls="pills-marketplace" aria-selected="false">Marketplace</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-study-sessions-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-study-sessions" href="#" role="tab"
                    aria-controls="pills-study-sessions" aria-selected="false">Study Sessions</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-restaurants-tab" data-bs-toggle="pill" data-bs-target="#pills-restaurants"
                    href="#" role="tab" aria-controls="pills-restaurants" aria-selected="false">Restaurants</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-announcements-tab" data-bs-toggle="pill" data-bs-target="#pills-announcements"
                    href="#" role="tab" aria-controls="pills-announcements"
                    aria-selected="false">Announcements</a>
            </li>
        </ul>


        <div class="tab-content" id="pills-tabContent">
            <!-- Materials Tab -->
            <div class="tab-pane fade show active" id="pills-materials" role="tabpanel"
                aria-labelledby="pills-materials-tab">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3" id="myGrid">
                    @foreach ($materials as $material)
                        <div class="col">
                            <div class="card border rounded-5">
                                <a href="{{ route('materials.show', $material->id) }}"
                                    class="text-decoration-none card-link">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-3">
                                            <span><i class="fas fa-folder mr-10px"
                                                    style="font-size: 20px; color:#4caf50"></i>
                                                <span style="color: #2a2f5b">{{ $material->course->code }}</span></span>
                                            <span class="text-muted">{{ $material->created_at->format('Y-m-d') }}</span>
                                        </div>
                                        <div class="text-center">
                                            <h4 class="card-title">{{ $material->title }}</h4>
                                        </div>
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
                                    </div>
                                </a>
                                <div class="card-footer"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="display: flex; align-items: center; color: #253c60;">
                                        <form action="{{ route('users.profile') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $material->user->id }}">
                                            <button type="submit" class="btn btn-link p-0"
                                                style="text-decoration: none !important; color: inherit; display: flex; align-items: center;">
                                                @if ($material->user->profile_image)
                                                    <div class="rounded-circle"
                                                        style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; background-color: #f0f0f0; margin-right: 5px;">
                                                        <img src="{{ asset('storage/' . $material->user->profile_image) }}"
                                                            alt="Profile Image" class="img-fluid rounded-circle"
                                                            style="width: 40px; height: 40px; object-fit: cover;">
                                                    </div>
                                                @else
                                                    <div class="rounded-circle"
                                                        style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center; background-color: #f0f0f0; margin-right: 5px;">
                                                        <i class="fas fa-user" style="font-size: 25px; color: #aaa;"></i>
                                                    </div>
                                                @endif
                                                <span class="user-name">By, {{ $material->user->name }}</span>
                                            </button>
                                        </form>
                                    </div>
                                    <button type="button" class="btn btn-rounded btn-danger delete-material"
                                        style="background-color: #e3342f; color: #fff;"
                                        data-material-id="{{ $material->id }}">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Announcements Tab -->
            <div class="tab-pane fade" id="pills-announcements" role="tabpanel"
                aria-labelledby="pills-announcements-tab">
                <!-- Check if there are no announcements -->
                @if ($announcements->isEmpty())
                    <div class="text-center">
                        <p>No Events available at the moment. Please check back later.</p>
                    </div>
                @else
                    <div class="container mt-4">
                        <div class="row">
                            @foreach ($announcements as $announcement)
                                <div class="col-12 mb-4">
                                    <div class="d-flex rounded-xl shadow-sm"
                                        style="height: 200px; background-color: #ffffff;">
                                        <div class="bg-primary text-white p-3 rounded-start"
                                            style="width: 200px; border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;">
                                            <p class="text-muted text-uppercase" style="font-size: 12px;">Category</p>
                                            <h2 class="font-weight-bold" style="font-size: 18px;">
                                                {{ $announcement->category }}</h2>
                                        </div>

                                        <div class="p-3 bg-light rounded-end w-100 position-relative"
                                            style="border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem;">
                                            <h3 class="mt-1" style="font-weight: 500; font-size: 15px;"><b>Title:</b>
                                                {{ $announcement->title }}</h3>
                                            <h3 class="mt-1" style="font-weight: 500; font-size: 15px;">
                                                <b>Description:</b>
                                                {{ $announcement->description }}
                                            </h3>

                                            <p class="card-text"><strong>Date:</strong>
                                                {{ \Carbon\Carbon::parse($announcement->event_date)->format('F j, Y h:i A') }}
                                            </p>
                                            <p class="mt-1" style="font-size: 14px;"><strong>Location:</strong>
                                                {{ $announcement->location }}
                                            </p>

                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-danger rounded-3 position-absolute"
                                                style="right: 10px; bottom: 10px;"
                                                data-announcement-id="{{ $announcement->id }}">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Marketplace Tab -->
            <div class="tab-pane fade" id="pills-marketplace" role="tabpanel" aria-labelledby="pills-marketplace-tab">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                    @foreach ($marketplaceItems as $item)
                        <div class="col">
                            <div class="card border rounded-5">
                                <div class="card-header d-flex align-items-center">
                                    @if ($item->user->profile_image)
                                        <div class="rounded-circle"
                                            style="width: 60px; height: 60px; display: flex; justify-content: center; align-items: center; background-color: #f0f0f0; margin-right:5px;">
                                            <img src="{{ asset('storage/' . $item->user->profile_image) }}"
                                                alt="Profile Image" class="img-fluid rounded-circle"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        </div>
                                    @else
                                        <div class="rounded-circle"
                                            style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; background-color: #f0f0f0; margin-right:5px;">
                                            <i class="fas fa-user" style="font-size: 30px; color: #aaa;"></i>
                                        </div>
                                    @endif
                                    <div class="ms-3">
                                        <h6 class="mb-0 fs-sm">By, {{ $item->user->name }}</h6>
                                        <span class="text-muted fs-sm">{{ $item->created_at->format('F j, Y') }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($item->image_path)
                                        <img src="{{ asset('storage/' . $item->image_path) }}" class="card-img-top"
                                            alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top"
                                            alt="No image available" style="height: 200px; object-fit: cover;">
                                    @endif
                                    <h4 class="card-title mt-3">{{ $item->title }}</h4>
                                    <p class="text-muted mb-2">{{ $item->category }} | Condition:
                                        {{ ucfirst($item->condition) }}</p>
                                    <p class="text-muted mb-0">{{ Str::limit($item->description, 100) }}</p>
                                    <span class="text-success fw-bold mt-2">Price: @if ($item->price === null)
                                            Free
                                        @else
                                            BD {{ $item->price }}
                                        @endif
                                    </span>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-rounded btn-danger w-100 mt-2 delete-item"
                                        data-item-id="{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Study Sessions Tab -->
            <div class="tab-pane fade" id="pills-study-sessions" role="tabpanel"
                aria-labelledby="pills-study-sessions-tab">
                <div class="row">
                    @foreach ($studySessions as $session)
                        <div class="col col-12 mb-4">
                            <div class="d-flex rounded-xl shadow-sm" style="height: 200px; background-color: #ffffff;">
                                <div class="bg-primary text-white p-3 rounded-start"
                                    style="width: 200px; border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;">
                                    <p class="text-muted text-uppercase" style="font-size: 12px;">Course</p>
                                    <h2 class="font-weight-bold" style="font-size: 18px;">{{ $session->course->name }}
                                    </h2>
                                </div>

                                <div class="p-3 bg-light rounded-end w-100 position-relative"
                                    style="border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem;">
                                    <h3 class="mt-1" style="font-weight: 500; font-size: 15px;"><b>Topic:</b>
                                        {{ $session->topic }}</h3>
                                    <h3 class="mt-1" style="font-weight: 500; font-size: 15px;"><b>Description:</b>
                                        {{ $session->description }}</h3>

                                    <p class="card-text"><strong>Date:</strong>
                                        {{ \Carbon\Carbon::parse($session->session_date)->format('F j, Y h:i A') }}</p>
                                    <p class="mt-1" style="font-size: 14px;"><strong>Location:</strong>
                                        {{ $session->location }}
                                    </p>
                                    <p class="mt-1" style="font-size: 14px;">
                                        <strong>Price: </strong>
                                        @if ($session->price_or_volunteer === 'price')
                                            BD {{ number_format($session->price, 2) }}
                                        @else
                                            Volunteer
                                        @endif
                                    </p>

                                    <button type="button" class="btn btn-danger delete-session position-absolute"
                                        style="right: 10px; bottom: 10px;" data-session-id="{{ $session->id }}"
                                        data-bs-toggle="modal" data-bs-target="#confirmDeleteSessionModal">
                                        Delete
                                    </button>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Restaurants Tab -->
            <div class="tab-pane fade" id="pills-restaurants" role="tabpanel" aria-labelledby="pills-restaurants-tab">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                    @foreach ($restaurants as $restaurant)
                        <div class="col">
                            <div class="card border rounded-5">
                                <!-- Card Header -->
                                <div class="card-header d-flex align-items-center">
                                    @if ($restaurant->user->profile_image)
                                        <div class="rounded-circle"
                                            style="width: 60px; height: 60px; display: flex; justify-content: center; align-items: center; background-color: #f0f0f0; margin-right:5px;">
                                            <img src="{{ asset('storage/' . $restaurant->user->profile_image) }}"
                                                alt="Profile Image" class="img-fluid rounded-circle"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        </div>
                                    @else
                                        <div class="rounded-circle"
                                            style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; background-color: #f0f0f0; margin-right:5px;">
                                            <i class="fas fa-user" style="font-size: 30px; color: #aaa;"></i>
                                        </div>
                                    @endif
                                    <div class="ms-3">
                                        <h6 class="mb-0 fs-sm">By, {{ $restaurant->user->name }}</h6>
                                        <span
                                            class="text-muted fs-sm">{{ $restaurant->created_at->format('F j, Y') }}</span>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    @if ($restaurant->menu_image)
                                        <a href="{{ asset('storage/' . $restaurant->menu_image) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $restaurant->menu_image) }}"
                                                class="card-img-top" alt="{{ $restaurant->name }} Menu"
                                                style="height: 200px; object-fit: cover;">
                                        </a>
                                    @else
                                        <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top"
                                            alt="No image available" style="height: 200px; object-fit: cover;">
                                    @endif

                                    <h4 class="card-title mt-3">{{ $restaurant->name }}</h4>
                                    <p class="text-muted mb-0">{{ Str::limit($restaurant->description, 100) }}</p>
                                    <p class="text-muted mb-2"><strong>Operating Hours:</strong>
                                        {{ $restaurant->operating_hours }}</p>
                                    <p class="text-muted"><strong>Location:</strong> {{ $restaurant->location }}</p>
                                </div>

                                <!-- Card Footer -->
                                <div class="card-footer">
                                    <button type="button" class="btn btn-rounded btn-danger delete-restaurant w-100"
                                        data-restaurant-id="{{ $restaurant->id }}" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteRestaurantModal">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    <!-- Confirm Delete Material Modal -->
    <div class="modal fade" id="confirmDeleteMaterialModal" tabindex="-1"
        aria-labelledby="confirmDeleteMaterialModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteMaterialModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this material?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteMaterial">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Announcement Modal -->
    <div class="modal fade" id="confirmDeleteAnnouncementModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmDeleteAnnouncementModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteAnnouncementModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this announcement?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteAnnouncement">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Restaurant Modal -->
    <div class="modal fade" id="confirmDeleteItemModal" tabindex="-1" aria-labelledby="confirmDeleteItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteItemModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this marketplace item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteItem">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Session Modal -->
    <div class="modal fade" id="confirmDeleteSessionModal" tabindex="-1"
        aria-labelledby="confirmDeleteSessionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteSessionModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this study session?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteSession">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Restaurant Modal -->
    <div class="modal fade" id="confirmDeleteRestaurantModal" tabindex="-1"
        aria-labelledby="confirmDeleteRestaurantModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteRestaurantModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this restaurant?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteRestaurant">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let materialIdToDelete = null;
            let itemIdToDelete = null;
            let sessionIdToDelete = null;
            let restaurantIdToDelete = null;
            let announcementIdToDelete = null;

            // delete for materials
            document.querySelectorAll('.delete-material').forEach(button => {
                button.addEventListener('click', function() {
                    materialIdToDelete = this.getAttribute('data-material-id');
                    $('#confirmDeleteMaterialModal').modal('show');
                });
            });

            // Confirm delete for materials
            document.getElementById('confirmDeleteMaterial').addEventListener('click', function() {
                fetch(`my-uploads/materials/${materialIdToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            document.querySelector(`[data-material-id="${materialIdToDelete}"]`)
                                .closest('.col').remove();
                        } else {
                            alert('Error deleting material.');
                        }
                    });
                $('#confirmDeleteMaterialModal').modal('hide');
            });

            // delete for announcements
            document.querySelectorAll('.btn-danger[data-announcement-id]').forEach(button => {
                button.addEventListener('click', function() {
                    announcementIdToDelete = this.getAttribute('data-announcement-id');
                    $('#confirmDeleteAnnouncementModal').modal('show');
                });
            });

            // Confirm delete for announcements
            document.getElementById('confirmDeleteAnnouncement').addEventListener('click', function() {
                if (announcementIdToDelete !== null) {
                    fetch(`/my-uploads/announcements/${announcementIdToDelete}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => {
                            if (response.ok) {
                                document.querySelector(
                                        `[data-announcement-id="${announcementIdToDelete}"]`)
                                    .closest('.col-12').remove();
                            } else {
                                alert('Error deleting announcement.');
                            }
                        });
                }
                $('#confirmDeleteAnnouncementModal').modal('hide');
            });

            // delete for marketplace 
            document.querySelectorAll('.delete-item').forEach(button => {
                button.addEventListener('click', function() {
                    itemIdToDelete = this.getAttribute('data-item-id');
                    $('#confirmDeleteItemModal').modal('show');
                });
            });

            // Confirm delete for marketplace 
            document.getElementById('confirmDeleteItem').addEventListener('click', function() {
                fetch(`my-uploads/marketplace/${itemIdToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            document.querySelector(`[data-item-id="${itemIdToDelete}"]`).closest('.col')
                                .remove();
                        } else {
                            alert('Error deleting item.');
                        }
                    });
                $('#confirmDeleteItemModal').modal('hide');
            });

            // delete for study sessions
            document.querySelectorAll('.delete-session').forEach(button => {
                button.addEventListener('click', function() {
                    sessionIdToDelete = this.getAttribute('data-session-id');
                    $('#confirmDeleteSessionModal').modal('show');
                });
            });

            // Confirm delete for study sessions
            document.getElementById('confirmDeleteSession').addEventListener('click', function() {
                fetch(`my-uploads/study-sessions/${sessionIdToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            // Use the correct variable name here
                            document.querySelector(`[data-session-id="${sessionIdToDelete}"]`).closest(
                                '.col').remove();
                        } else {
                            alert('Error deleting study session.');
                        }
                    });
                $('#confirmDeleteSessionModal').modal('hide');
            });

            // delete for restaurants
            document.querySelectorAll('.delete-restaurant').forEach(button => {
                button.addEventListener('click', function() {
                    restaurantIdToDelete = this.getAttribute('data-restaurant-id');
                    $('#confirmDeleteRestaurantModal').modal('show');
                });
            });

            // Confirm delete for restaurants
            document.getElementById('confirmDeleteRestaurant').addEventListener('click', function() {
                fetch(`my-uploads/restaurants/${restaurantIdToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            // Use the correct variable name here
                            document.querySelector(`[data-restaurant-id="${restaurantIdToDelete}"]`)
                                .closest('.col').remove();
                        } else {
                            alert('Error deleting restaurant.');
                        }
                    });
                $('#confirmDeleteRestaurantModal').modal('hide');
            });
        });
    </script>
@endsection
