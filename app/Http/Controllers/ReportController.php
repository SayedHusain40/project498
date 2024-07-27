<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\College;
use App\Models\Course;
use TCPDF;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function generate(Request $request)
    {
        $reportType = $request->input('report_type');

        switch ($reportType) {
            case 'users':
                $data = User::all();
                $pdf = $this->generateUsersPDF($data);
                return $pdf->Output('users_report.pdf', 'D');
            case 'departments':
                $data = Department::all();
                $pdf = $this->generateDepartmentsPDF($data);
                return $pdf->Output('departments_report.pdf', 'D');
            case 'colleges':
                $data = College::all();
                $pdf = $this->generateCollegesPDF($data);
                return $pdf->Output('colleges_report.pdf', 'D');
            case 'courses':
                $data = Course::all();
                $pdf = $this->generateCoursesPDF($data);
                return $pdf->Output('courses_report.pdf', 'D');
            default:
                return back()->withErrors(['Invalid report type selected']);
        }
    }

    private function generateUsersPDF($users)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $html = '<h1>Users Report</h1>';
        $html .= '<table border="1" cellpadding="4">';
        $html .= '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Created At</th></tr></thead>';
        $html .= '<tbody>';
        foreach ($users as $user) {
            $html .= '<tr>';
            $html .= '<td>' . $user->id . '</td>';
            $html .= '<td>' . $user->name . '</td>';
            $html .= '<td>' . $user->email . '</td>';
            $html .= '<td>' . $user->created_at . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf;
    }

    private function generateDepartmentsPDF($departments)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $html = '<h1>Departments Report</h1>';
        $html .= '<table border="1" cellpadding="4">';
        $html .= '<thead><tr><th>ID</th><th>Name</th><th>College ID</th><th>Created At</th><th>Updated At</th></tr></thead>';
        $html .= '<tbody>';
        foreach ($departments as $department) {
            $html .= '<tr>';
            $html .= '<td>' . $department->id . '</td>';
            $html .= '<td>' . $department->name . '</td>';
            $html .= '<td>' . $department->college_id . '</td>';
            $html .= '<td>' . $department->created_at . '</td>';
            $html .= '<td>' . $department->updated_at . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf;
    }

    private function generateCollegesPDF($colleges)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $html = '<h1>Colleges Report</h1>';
        $html .= '<table border="1" cellpadding="4">';
        $html .= '<thead><tr><th>ID</th><th>Name</th></tr></thead>';
        $html .= '<tbody>';
        foreach ($colleges as $college) {
            $html .= '<tr>';
            $html .= '<td>' . $college->id . '</td>';
            $html .= '<td>' . $college->name . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf;
    }

    private function generateCoursesPDF($courses)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $html = '<h1>Courses Report</h1>';
        $html .= '<table border="1" cellpadding="4">';
        $html .= '<thead><tr><th>ID</th><th>Name</th><th>Department ID</th><th>Created At</th><th>Updated At</th></tr></thead>';
        $html .= '<tbody>';
        foreach ($courses as $course) {
            $html .= '<tr>';
            $html .= '<td>' . $course->id . '</td>';
            $html .= '<td>' . $course->name . '</td>';
            $html .= '<td>' . $course->department_id . '</td>';
            $html .= '<td>' . $course->created_at . '</td>';
            $html .= '<td>' . $course->updated_at . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf;
    }
}
