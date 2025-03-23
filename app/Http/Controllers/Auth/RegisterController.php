<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Brand;
use App\Models\Register;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    // /**
    //  * Where to redirect users after registration.
    //  *
    //  * @var string
    //  */
    // protected $redirectTo = RouteServiceProvider::HOME;

    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    // /**
    //  * Get a validator for an incoming registration request.
    //  *
    //  * @param  array  $data
    //  * @return \Illuminate\Contracts\Validation\Validator
    //  */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    // /**
    //  * Create a new user instance after a valid registration.
    //  *
    //  * @param  array  $data
    //  * @return \App\Models\User
    //  */
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //     ]);
    // }




    public function showRegisterForm(){
        $data['brands'] = Brand::get();
        return view('auth.register', compact('data'));
    }

    public function register(Request $request){
        // return $request->all();
        // $request->validate([
        //     'name' => 'required|string',
        //     // 'mobile_no' => 'required|unique:users,contact',
        //     // 'email' => 'required||email|unique:registers,email',
        //     // 'area' => 'required|string',
        //     // 'password' => 'required|string',
        // ],
        // [
        //     'mobile_no.unique' => 'Contact Already Exist'
        // ]);

        $register = new Register();
        $register->name = $request->name;
        $register->mobile = $request->mobile_no;
        $register->email = $request->email_id;
        $register->password = $request->password;
        $register->address = $request->address;
        $register->role = $request->role;
        $register->description = $request->description;

        if($register->save()){
            return redirect('register')->with('success', 'Registration Form Successfully Inserted');

        } else {
            return back()->with('error', 'Something Went Wrong');
        };
    }

    public function checkMobileNumber(Request $request){
        $CheckMobile = Register::where('mobile', $request->mobile)->first();        
        if ($CheckMobile) {
            return '<span class="fa fa-times text-danger">  Mobile Already Exist</span>';
        } else {
            return '<span class="fa fa-check text-success">  Mobile Available</span>';
        }
    }

    public function checkEmail(Request $request){
        $CheckEmail = Register::where('email', $request->email)->first();   
        if ($CheckEmail) {
          return '<span class="fa fa-times text-danger">  Email Already Exist</span>';
          //  return $return='TRUE';
        } else {
          return '<span class="fa fa-check text-success">  Email Available</span>';
          // return $return='FALSE';
        }

    }
}
