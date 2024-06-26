<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    // for only redirect to post page
    public function index()
    {
        return view('posts');
    }

    // for Store a new created post
    public function store(Request $request)
    {
        // Validate the data
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        // Create the post "store the data in post table"
        $post = Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        // Redirect to the posts page 
        return redirect()->route('posts');
    }
}
