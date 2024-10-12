@extends('new_layouts.app')

@section('title', 'Admin dashbored')

@section('content')
    <div class="row row-card-no-pd">
        <div style="font-size: 20px">
            Admin Page
        </div>
    </div>


<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-box"></i> <!-- Example icon -->
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Materials</p>
                            <h4 class="card-title">{{ $materialsCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Subscribers</p>
                            <h4 class="card-title">{{ $usersCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Display user data in Table -->

<div class="container mt-4">
    <h2>Users List</h2>
    <table class="table table-striped table-hover table-bordered" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <thead style="background-color: #4a90e2; color: white;">
            <tr>
                <th style="border-top-left-radius: 10px; padding: 15px;">Name</th>
                <th style="padding: 15px;">Email</th>
                <th style="padding: 15px;">Role</th>
                <th style="border-top-right-radius: 10px; padding: 15px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr style="transition: all 0.3s ease;">
                <td style="padding: 15px;">{{ $user->name }}</td>
                <td style="padding: 15px;">{{ $user->email }}</td>
                <td style="padding: 15px;">{{ $user->role }}</td>
                <td style="padding: 15px;">
                    <!-- Edit Button -->
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary btn-sm">Edit</a>

                    <!-- Delete Button -->
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot style="background-color: #f9f9f9;">
            <tr>
                <td colspan="4" class="text-center" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; padding: 15px;">
                    <small class="text-muted">Showing {{ count($users) }} users</small>
                </td>
            </tr>
        </tfoot>
    </table>
</div>









@endsection
