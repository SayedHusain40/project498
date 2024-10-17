<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function profile(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::with(['department', 'expertise'])->findOrFail($request->input('user_id'));

        return view('profile.users', compact('user'));
    }

}
