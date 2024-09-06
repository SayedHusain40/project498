<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivityController extends Controller
{
    public function getChartData(Request $request)
    {
        $period = $request->input('period', '1month'); // Default to 1 month
        $startTime = Carbon::now();
    
        switch ($period) {
            case '1hour':
                $startTime = $startTime->subHour();
                $interval = '%Y-%m-%d %H:%i';
                break;
            case '1day':
                $startTime = $startTime->subDay();
                $interval = '%Y-%m-%d %H:00';
                break;
            case '1month':
                $startTime = $startTime->subMonth();
                $interval = '%Y-%m-%d';
                break;
            case '3months':
                $startTime = $startTime->subMonths(3);
                $interval = '%Y-%m-%d';
                break;
            case '1year':
                $startTime = $startTime->subYear();
                $interval = '%Y-%m';
                break;
            default:
                $startTime = $startTime->subMonth();
                $interval = '%Y-%m-%d';
                break;
        }
    
        $logins = DB::table('user_sessions')
            ->where('created_at', '>=', $startTime)
            ->select(DB::raw("COUNT(*) as count"), DB::raw("DATE_FORMAT(created_at, '$interval') as time"))
            ->groupBy('time')
            ->orderBy('time', 'asc')
            ->get();
    
        $labels = $logins->pluck('time');
        $data = $logins->pluck('count');
    
        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}