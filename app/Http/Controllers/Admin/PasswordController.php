<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        return view('admin.change_password.index');
    }

    public function store(Request $request)
    {

        $auth = Auth::user();


        $user =  User::find($auth->id);
        $user->password =  bcrypt($request->new_password);
        $user->save();
        return back()->with('success', "Password Changed Successfully");
    }
}
