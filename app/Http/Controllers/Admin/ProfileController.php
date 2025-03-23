<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.profile', compact('user'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find(Auth::id()); // Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->new_password) {
            $user->password =  bcrypt($request->new_password);
        }
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
