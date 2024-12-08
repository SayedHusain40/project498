<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                Password::min(8) // Minimum length of 8 characters
                    ->letters() // At least one letter
                    ->mixedCase() // At least one uppercase and one lowercase letter
                    ->numbers() // At least one number
                    ->symbols(), // At least one special character
                'confirmed' // Make sure passwords match
            ],
        ]);

        // Update the user's password
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect back with success message
        return back()->with('status', 'password-updated');
    }
}
