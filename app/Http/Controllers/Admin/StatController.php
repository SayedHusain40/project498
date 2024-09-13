<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\User;

class StatController extends Controller
{
    public function index()
    {
        $materialsCount = Material::count();
        $usersCount = User::where('role', 'user')->count();
        $users = User::all();

        return view('admin.dashboard', [
            'materialsCount' => $materialsCount,
            'usersCount' => $usersCount,
            'users' => $users
        ]);
    }
}



