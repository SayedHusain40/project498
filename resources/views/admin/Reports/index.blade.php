@extends('new_layouts.app')

@section('content')
    <h1>Generate Reports</h1>
    <form action="{{ route('admin.reports.generate') }}" method="POST">
        @csrf
        <label for="report_type">Select Report Type:</label>
        <select name="report_type" id="report_type">
        <option value="users">Users Report</option>
        <option value="departments">Departments Report</option>
        <option value="colleges">Colleges Report</option>
        <option value="courses">Courses Report</option>
        </select>
        <button type="submit">Generate Report</button>
    </form>
@endsection
