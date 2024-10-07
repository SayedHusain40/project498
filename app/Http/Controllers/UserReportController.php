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

        if ($request->report_type === 'comment') {
            CommentReport::create([
                'comment_id' => $request->report_id,
                'user_id' => Auth::id(),
                'reason' => $request->reason,
            ]);
        } elseif ($request->report_type === 'material') {
            MaterialReport::create([
                'material_id' => $request->report_id,
                'user_id' => Auth::id(),
                'reason' => $request->reason,
            ]);
        }

        return response()->json(['success' => true]);
    }
}
