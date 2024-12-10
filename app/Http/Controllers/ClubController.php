<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::with('user')->get();
        return view('clubs.index', compact('clubs'));
    }

    public function create()
    {
        return view('clubs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Academic,Social and Volunteer,Sports,Professional Development,Arts and Creativity,Technology and Innovation,Environmental Clubs',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('storage/clubs_images'), $imageName);
            $imagePath = 'clubs_images/' . $imageName;
        }

        // Create the Club
        Club::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'image' => $imagePath, // Store image path
        ]);

        return redirect()->route('clubs.index')->with('success', 'Club created successfully.');
    }

}

