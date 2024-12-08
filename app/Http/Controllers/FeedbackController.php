<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    //
    public function index() {
        return View('feedback');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5', // Ensure rating is between 1 and 5
            'feedback' => 'nullable|string|max:500',  
        ]);

        Feedback::create([
            'rating' => $validated['rating'],
            'feedback' => $validated['feedback'],
        ]);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
}
