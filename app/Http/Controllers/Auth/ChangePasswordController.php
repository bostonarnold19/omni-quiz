<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    /**
     * Show the change password form.
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Handle the password update.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]);

        // Update the password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->password_crack = $request->new_password;
        $user->save();

        return redirect()->route('new-password.change')->with('success', 'Password updated successfully!');
    }
}
