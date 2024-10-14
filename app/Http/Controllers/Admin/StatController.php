<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
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




    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.EditUser', compact('user'));
    }

    // Update user informations
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully');
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }


}



