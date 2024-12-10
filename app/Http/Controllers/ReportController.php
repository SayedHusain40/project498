<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Material;
use App\Models\Marketplace;
use App\Models\StudySession;
use App\Models\Restaurant;
use App\Models\Announcement;
use Illuminate\Http\Request;
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
            case 'materials':
                $data = Material::all();
                $pdf = $this->generateMaterialsPDF($data);
                return $pdf->Output('materials_report.pdf', 'D');
            case 'marketplaces':
                $data = Marketplace::all();
                $pdf = $this->generateMarketplacesPDF($data);
                return $pdf->Output('marketplaces_report.pdf', 'D');
            case 'study_sessions':
                $data = StudySession::all();
                $pdf = $this->generateStudySessionsPDF($data);
                return $pdf->Output('study_sessions_report.pdf', 'D');
            case 'restaurants':
                $data = Restaurant::all();
                $pdf = $this->generateRestaurantsPDF($data);
                return $pdf->Output('restaurants_report.pdf', 'D');
            case 'announcements': // Adding case for announcements
                $data = Announcement::all(); // Fetch all announcements
                $pdf = $this->generateAnnouncementsPDF($data);
                return $pdf->Output('announcements_report.pdf', 'D');
            default:
                return back()->withErrors(['Invalid report type selected']);
        }
    }

    private function generateUsersPDF($users)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();

        // Add custom Bootstrap-like styles for table
        $style = '
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            h1 { text-align: center; font-size: 24px; margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            table th, table td { padding: 10px; text-align: left; border: 1px solid #ddd; }
            table th { background-color: #f8f9fa; font-weight: bold; }
            table tr:nth-child(even) { background-color: #f2f2f2; }
            table tr:hover { background-color: #f1f1f1; }
        </style>';

        // Create table content
        $html = $style . '
        <h1>Users Report</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($users as $user) {
            $html .= '
                <tr>
                    <td>' . $user->id . '</td>
                    <td>' . $user->name . '</td>
                    <td>' . $user->email . '</td>
                    <td>' . $user->created_at . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf;
    }

    private function generateMaterialsPDF($materials)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();

        $style = '
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            h1 { text-align: center; font-size: 24px; margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            table th, table td { padding: 10px; text-align: left; border: 1px solid #ddd; }
            table th { background-color: #f8f9fa; font-weight: bold; }
            table tr:nth-child(even) { background-color: #f2f2f2; }
            table tr:hover { background-color: #f1f1f1; }
        </style>';

        $html = $style . '
        <h1>Materials Report</h1>
        <table>
            <thead>
                <tr>
                    <th colspan="6" style="text-align: center;">Materials Overview</th>
                </tr>
                <tr>
                    <th rowspan="2">ID</th>
                    <th rowspan="2">User ID</th>
                    <th colspan="2">Details</th>
                    <th rowspan="2">No. Files</th>
                    <th rowspan="2">Created At</th>
                </tr>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($materials as $material) {
            $html .= '
                <tr>
                    <td>' . $material->id . '</td>
                    <td>' . $material->user_id . '</td>
                    <td>' . $material->title . '</td>
                    <td>' . $material->description . '</td>
                    <td>' . $material->file_count . '</td>
                    <td>' . $material->created_at . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf;
    }

    private function generateMarketplacesPDF($marketplaces)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();

        $style = '
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            h1 { text-align: center; font-size: 24px; margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            table th, table td { padding: 10px; text-align: left; border: 1px solid #ddd; }
            table th { background-color: #f8f9fa; font-weight: bold; }
            table tr:nth-child(even) { background-color: #f2f2f2; }
            table tr:hover { background-color: #f1f1f1; }
        </style>';

        $html = $style . '
        <h1>Marketplaces Report</h1>
        <table>
            <thead>
                <tr>
                    <th colspan="8" style="text-align: center;">Marketplaces Overview</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Condition</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($marketplaces as $marketplace) {
            $html .= '
                <tr>
                    <td>' . $marketplace->id . '</td>
                    <td>' . $marketplace->user_id . '</td>
                    <td>' . $marketplace->title . '</td>
                    <td>' . $marketplace->description . '</td>
                    <td>' . $marketplace->price . '</td>
                    <td>' . $marketplace->category . '</td>
                    <td>' . $marketplace->condition . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf;
    }

    private function generateStudySessionsPDF($study_sessions)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();

        $style = '
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            h1 { text-align: center; font-size: 24px; margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            table th, table td { padding: 10px; text-align: left; border: 1px solid #ddd; }
            table th { background-color: #f8f9fa; font-weight: bold; }
            table tr:nth-child(even) { background-color: #f2f2f2; }
            table tr:hover { background-color: #f1f1f1; }
        </style>';

        $html = $style . '
        <h1>Study Sessions Report</h1>
        <table>
            <thead>
                <tr>
                    <th colspan="8" style="text-align: center;">Study Sessions Overview</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Topic</th>
                    <th>Description</th>
                    <th>Session Date</th>
                    <th>Location</th>
                    <th>Price/Volunteer</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($study_sessions as $session) {
            $html .= '
                <tr>
                    <td>' . $session->id . '</td>
                    <td>' . $session->user_id . '</td>
                    <td>' . $session->topic . '</td>
                    <td>' . $session->description . '</td>
                    <td>' . $session->session_date . '</td>
                    <td>' . $session->location . '</td>
                    <td>' . $session->price_or_volunteer . '</td>
                    <td>' . $session->price . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf;
    }

    private function generateRestaurantsPDF($restaurants)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();

        $style = '
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            h1 { text-align: center; font-size: 24px; margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            table th, table td { padding: 10px; text-align: left; border: 1px solid #ddd; }
            table th { background-color: #f8f9fa; font-weight: bold; }
            table tr:nth-child(even) { background-color: #f2f2f2; }
            table tr:hover { background-color: #f1f1f1; }
        </style>';

        $html = $style . '
        <h1>Restaurants Report</h1>
        <table>
            <thead>
                <tr>
                    <th colspan="7" style="text-align: center;">Restaurants Overview</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Operating Hours</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($restaurants as $restaurant) {
            $html .= '
                <tr>
                    <td>' . $restaurant->id . '</td>
                    <td>' . $restaurant->user_id . '</td>
                    <td>' . $restaurant->name . '</td>
                    <td>' . $restaurant->description . '</td>
                    <td>' . $restaurant->operating_hours . '</td>
                    <td>' . $restaurant->location . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf;
    }

    private function generateAnnouncementsPDF($announcements)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();

        $style = '
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            h1 { text-align: center; font-size: 24px; margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            table th, table td { padding: 10px; text-align: left; border: 1px solid #ddd; }
            table th { background-color: #f8f9fa; font-weight: bold; }
            table tr:nth-child(even) { background-color: #f2f2f2; }
            table tr:hover { background-color: #f1f1f1; }
        </style>';

        $html = $style . '
        <h1>Announcements Report</h1>
        <table>
            <thead>
                <tr>
                    <th colspan="6" style="text-align: center;">Announcements Overview</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Event Date</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($announcements as $announcement) {
            $html .= '
                <tr>
                    <td>' . $announcement->id . '</td>
                    <td>' . $announcement->title . '</td>
                    <td>' . $announcement->description . '</td>
                    <td>' . $announcement->category . '</td>
                    <td>' . $announcement->location . '</td>
                    <td>' . $announcement->event_date . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf;
    }


}
