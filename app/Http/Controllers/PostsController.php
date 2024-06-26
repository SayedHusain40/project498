<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function store(){
        $posts = posts::create(
            [
            'content' => request()-> get('posts',''),
            ]
            );
            return view('posts');
    }
}
