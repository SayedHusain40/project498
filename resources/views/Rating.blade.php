@extends('new_layouts.app')

@section('content')
<div class="container">
    <h1>Users Feedback</h1>
    <form method="GET" action="{{ route('ratings.index') }}" class="mb-3">
        <div class="form-group">
            <label for="filter" class="d-block">Filter Feedbacks</label>
            <select name="filter" id="filter" class="form-control custom-select" onchange="this.form.submit()">
                <option value="All" {{ $filter === 'All' ? 'selected' : '' }}>All</option>
                <option value="Reviewed" {{ $filter === 'Reviewed' ? 'selected' : '' }}>Reviewed</option>
                <option value="Unreviewed" {{ $filter === 'Unreviewed' ? 'selected' : '' }}>Unreviewed</option>
            </select>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Rating</th>
                <th>Feedback</th>
                <th>User</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($feedbacks as $feedback)
            <tr>
                <td>{{ $feedback->id }}</td>
                <td>{{ $feedback->rating }}</td>
                <td>{{ $feedback->feedback ?? 'No feedback provided' }}</td>
                <td>{{ $feedback->user->name }}</td>
                <td>
                    <form method="POST" action="{{ route('ratings.markReviewed', $feedback->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">Reviewed</button>
                    </form>
                    <form action="{{ route('users.profile') }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $feedback->user_id }}">
                        <button type="submit" class="btn btn-primary">Contact</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
