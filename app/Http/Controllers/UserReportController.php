<?php

namespace App\Http\Controllers;

use App\Models\CommentReport;
use App\Models\MaterialReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReportController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'report_id' => 'required|integer',
            'report_type' => 'required|in:material,comment',
            'reason' => 'nullable|string',
        ]);

        // Determine which table to insert the report into
        if ($request->report_type === 'comment') {
            // Create a comment report
            CommentReport::create([
                'comment_id' => $request->report_id,
                'user_id' => Auth::id(),
                'reason' => $request->reason,
            ]);
        } elseif ($request->report_type === 'material') {
            // Create a material report
            MaterialReport::create([
                'material_id' => $request->report_id,
                'user_id' => Auth::id(),
                'reason' => $request->reason,
            ]);
        }

        return response()->json(['success' => true]);
    }
}
