@extends('new_layouts.app')

@section('content')

<table class="table table-striped table-hover table-bordered" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <thead class="thead-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Type</th>
        <th scope="col">Reported Content</th>
        <th scope="col">Reported By</th>
        <th scope="col">Reason</th>
        <th scope="col">Reported At</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($reports as $index => $report)
        <tr>
          <th scope="row">{{ $index + 1 }}</th>
          <td>{{ $report->type }}</td>
          <td>{{ $report->content }}</td>
          <td>{{ $report->reported_by }}</td>
          <td>{{ $report->reason }}</td>
          <td>{{ $report->created_at }}</td>
          <td>
            <!-- Allow Button -->
            <form action="{{ route('moderate.allow', [$report->type, $report->report_id]) }}" method="POST" style="display:inline;">
              @csrf
              <button type="submit" class="btn btn-outline-success btn-sm">Allow</button>
            </form>

            <!-- Delete Button -->
            <form action="{{ route('moderate.delete', [$report->type, $report->report_id]) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this report?');">Delete</button>
            </form>

            <!-- View Button -->
            <a href="{{ route('moderate.view', [$report->type, $report->reported_id]) }}" class="btn btn-info btn-sm">View</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>




@endsection
