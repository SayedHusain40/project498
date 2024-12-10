<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marketplace;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MarketplaceController extends Controller
{
    public function index()
    {
        $items = Marketplace::with('user')->get(); 
        return view('marketplaces.index', compact('items')); 
    }

    public function showUploadForm()
    {
        return view('marketplaces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string|max:150',
            'price_option' => 'required',
            'category' => 'required|string',
            'condition' => 'required|in:new,used',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $price = null;
        if ($request->input('price_option') === 'price') {
            $price = $request->input('price'); 
        } 

        $path = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('storage/marketplace'), $imageName);
            $path = 'marketplace/' . $imageName;
        }

        Marketplace::create([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $price,
            'category' => $request->input('category'),
            'condition' => $request->input('condition'),
            'image_path' => $path,
        ]);

        return redirect()->route('marketplace')->with('success', 'Marketplace item uploaded successfully!');
    }
}
