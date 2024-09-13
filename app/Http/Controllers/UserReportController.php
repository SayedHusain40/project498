<?php

namespace App\Http\Controllers;

use App\Models\UserReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserReportController extends Controller
{
    //
    public function submit(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:materials,id',
            'reason' => 'nullable|string',
        ]);

        // Create the report
        UserReport::create([
            'report_type' => 'material', 
            'report_id' => $request->report_id,
            'user_id' => Auth::id(),
            'reason' => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Report submitted successfully.');
    }



}
