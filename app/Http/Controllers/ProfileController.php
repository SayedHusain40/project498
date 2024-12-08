<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Storage;



class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }

    public function updateImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $imageName = time() . '_' . $request->file('profile_image')->getClientOriginalName();
            $request->file('profile_image')->move(public_path('storage/profile_images'), $imageName);
            $path = 'profile_images/' . $imageName;
            $user = auth()->user();
            $user->profile_image = $path;
            $user->save();
        }
        return back()->with('status', 'Profile image updated successfully!');
    }
    public function removeImage()
    {
        $user = auth()->user();

        if ($user->profile_image) {
            $imagePath = public_path('storage/' . $user->profile_image);
            if (file_exists($imagePath)) {
                unlink($imagePath); 
            }
            $user->profile_image = null;
            $user->save();
        }

        return back()->with('status', 'Profile image removed successfully!');
    }




    public function edit(Request $request): View
    {
        // Load the user's major and expertise for the edit form
        $user = User::with(['major', 'expertise'])->find(Auth::id());

        // Return the view for editing the profile
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


}
