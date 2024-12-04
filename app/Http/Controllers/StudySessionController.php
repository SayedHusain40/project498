<?php

namespace App\Http\Controllers;

use App\Models\StudySession;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudySessionController extends Controller
{
    public function index()
    {
        $studySessions = StudySession::with('user', 'course')
            ->where('session_date', '>=', now()->setTimezone('Asia/Bahrain'))
            ->get();
        return view('study_sessions.index', compact('studySessions'));
    }

    public function create()
    {
        $courses = Course::all(); 
        return view('study_sessions.create', compact('courses')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'session_date' => 'required|date',
            'location' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'price_or_volunteer' => 'required|in:price,volunteer',
            'price' => 'nullable|numeric|min:0|required_if:price_or_volunteer,price',
        ]);

        StudySession::create([
            'topic' => $request->topic,
            'description' => $request->description,
            'session_date' => $request->session_date,
            'location' => $request->location,
            'user_id' => Auth::id(),
            'course_id' => $request->course_id,
            'price_or_volunteer' => $request->price_or_volunteer,
            'price' => $request->price,  
        ]);

        
        return redirect()->route('study-sessions.index')->with('success', 'Study session posted successfully!');
    }
}
