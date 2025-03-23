<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Appointment;
use App\Models\NewsLetter;
use Illuminate\Support\Facades\Session;

class BackendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // public function login(Request $request){
    //     $user = User::where('email', $request->email)->where('password', $request->password)->first();
    //     if($user){
    //         session(['user_id' => $user->id, 'user_name' => $user->name]);
    //         // Session::set('user_id', $user->id);
    //         // \Session::put('userid', $user->id);
    //         return redirect()->route('admin.contact');
    //     }else{
    //         return redirect()->route('login')->with('error', 'Invalid email or password');
    //     }
    // }

    public function contactList(){
        $this->middleware('auth');
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return view('backend.form.contact', compact('contacts'));
    }

    public function newsLetter(){
        $this->middleware('auth');
        $newsLetters = NewsLetter::orderBy('created_at', 'desc')->get();
        return view('backend.form.newsLetter', compact('newsLetters'));
    }

    public function appointment(){
        $this->middleware('auth');
        $appointments = Appointment::orderBy('created_at', 'desc')->get();
        return view('backend.form.appointment', compact('appointments'));
    }
}
