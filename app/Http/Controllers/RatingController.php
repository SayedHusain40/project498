<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\ReviewedFeedback;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'All');
        $feedbacks = Feedback::with('user')->when($filter === 'Reviewed', function ($query) {
            $query->whereIn('id', ReviewedFeedback::pluck('feedback_id'));
        })->when($filter === 'Unreviewed', function ($query) {
            $query->whereNotIn('id', ReviewedFeedback::pluck('feedback_id'));
        })->get();

        return view('rating', compact('feedbacks', 'filter'));
    }

    public function markReviewed($id)
    {
        ReviewedFeedback::firstOrCreate(['feedback_id' => $id]);
        return redirect()->back()->with('success', 'Feedback marked as reviewed.');
    }
}

