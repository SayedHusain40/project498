<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('user')->get();
        return view('restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        return view('restaurants.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'operating_hours' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'menu_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $menuImagePath = null;
        if ($request->hasFile('menu_image')) {
            $imageName = time() . '_' . $request->file('menu_image')->getClientOriginalName();
            $request->file('menu_image')->move(public_path('storage/menus'), $imageName);
            $menuImagePath = 'menus/' . $imageName;
        }

        Restaurant::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'operating_hours' => $request->operating_hours,
            'location' => $request->location,
            'menu_image' => $menuImagePath,
        ]);

        return redirect()->route('restaurants.index')->with('success', 'Restaurant created successfully.');
    }


}
