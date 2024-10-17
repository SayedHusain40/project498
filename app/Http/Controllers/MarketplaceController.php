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
        return view('uploads.marketplace');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'condition' => 'required|in:new,used',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $marketplaceItem = new Marketplace();
        $marketplaceItem->user_id = Auth::id();
        $marketplaceItem->title = $request->input('title');
        $marketplaceItem->description = $request->input('description');
        $marketplaceItem->price = $request->input('price');
        $marketplaceItem->category = $request->input('category');
        $marketplaceItem->condition = $request->input('condition');

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();

            $request->file('image')->move(public_path('storage/marketplace'), $imageName);

            $marketplaceItem->image_path = 'marketplace/' . $imageName;
        }

        $marketplaceItem->save();

        return redirect()->route('marketplace.show')->with('success', 'Marketplace item uploaded successfully!');
    }



}
