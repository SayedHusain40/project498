<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function fetchChartData(Request $request)
    {
        $month = $request->input('month', date('m')); // Default to the current month

        // Fetch data grouped by day for each table
        $materials = \DB::table('materials')
            ->selectRaw('DAY(created_at) as day, COUNT(*) as count')
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->pluck('count', 'day');

        $items = \DB::table('marketplaces')
            ->selectRaw('DAY(created_at) as day, COUNT(*) as count')
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->pluck('count', 'day');

        $studySessions = \DB::table('study_sessions')
            ->selectRaw('DAY(created_at) as day, COUNT(*) as count')
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->pluck('count', 'day');

        $events = \DB::table('announcements')
            ->selectRaw('DAY(updated_at) as day, COUNT(*) as count')
            ->whereMonth('updated_at', $month)
            ->groupBy('day')
            ->pluck('count', 'day');

        // Return the data as JSON
        return response()->json([
            'materials' => $materials,
            'items' => $items,
            'study_sessions' => $studySessions,
            'events' => $events,
        ]);
    }

}
