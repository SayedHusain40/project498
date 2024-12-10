<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    // Display all announcements
    public function index()
    {
        $announcements = Announcement::latest()
        ->where('event_date', '>=', now()->setTimezone('Asia/Bahrain'))
        ->get();
        return view('announcements.index', compact('announcements'));
    }

    // Show the form for creating a new announcement
    public function create()
    {
        $categories = [
            'Academic',
            'Career Development',
            'Community Engagement',
            'Competitions and Hackathons',
            'Entertainment and Social',
        ];

        return view('announcements.create', compact('categories'));
    }

    // Store a newly created announcement
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:200',
            'category' => 'required|in:Academic,Career Development,Community Engagement,Competitions and Hackathons,Entertainment and Social',
            'location' => 'required|string|max:50',
            'event_date' => 'required|date',
        ]);

        Announcement::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'event_date' => $request->event_date,
        ]);

        return redirect()->route('announcements.index')->with('success', 'Announcement created successfully!');
    }
}

