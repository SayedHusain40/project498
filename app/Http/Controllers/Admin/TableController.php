<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tables; // Import the Tables model

class TableController extends Controller
{
    public function index()
    {
        
        $users = Tables::select('id', 'name', 'role', 'email', 'created_at')
                        ->where('role', 'user') 
                        ->get();

        
        return view('admin.dashboard', ['users' => $users]);
    }
}



