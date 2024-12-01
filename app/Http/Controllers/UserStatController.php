<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\User;

class UserStatController extends Controller
{
    public function index()
    {
        $materialsCounts = Material::count();
        $usersCounts = User::where('role', 'user')->count();
        $userss = User::all();
        $totalDownloadss = \DB::table('files')->sum('downloads');

        return view('dashboard.blade', [
            'materialsCount' => $materialsCounts,
            'usersCount' => $usersCounts,
            'totalDownloads' => $totalDownloadss,
            'users' => $userss
        ]);
    }
}
