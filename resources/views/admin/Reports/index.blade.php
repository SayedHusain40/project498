@extends('new_layouts.app')

@section('content')
    <h1>Generate Reports</h1>

    <form action="{{ route('admin.reports.generate') }}" method="POST">
        @csrf
<div class="container mt-5">
    <div class="mb-3">
        <label for="report_type" class="form-label">Select Report Type:</label>
        <select name="report_type" id="report_type" class="form-select">
            <option value="users">Users Report</option>
            <option value="departments">Departments Report</option>
            <option value="colleges">Colleges Report</option>
            <option value="courses">Courses Report</option>
        </select>
    </div>
</div>
        <div class="mt-4">
        <button type="submit" class="btn btn-primary w-100 py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                                    Generrate Report
        </button>
        </div>
    </form>

@endsection
