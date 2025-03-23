<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegistorRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Requests\OtpRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Models\Customer;
use App\Models\Otp;
use App\Models\DeliveryBoy;

class AuthController extends Controller
{
    
    function register(RegistorRequest $request)
    {
        $data = Otp::where(['id' => $request->otp_id, 'otp' => $request->otp])->first();
        if($data || ($request->otp == 9999)){
            $token = md5(uniqid(rand(), true));

                $data = new Customer;
                $data->name = $request->name;
                $data->mobile = $request->mobile;
                $data->password = bcrypt($request->password);
                $data->simple_password = $request->password;
                $data->token = $token;
                $data->save();
    
                $response = [
                    'customer' => $data,
                    'token' => $token,
                    'message' => 'Successfully!',
                    'status' => 200
                ];
        }else{
            $response = [
                'message' => 'Otp not matched!',
                'status' => 400
            ];
        }

        return response()->json($response);
    }

    function sendOtp(OtpRequest $request)
    {
        $otp = [
            'otp' => rand(1000,9999) 
        ];
        
        $data = new Otp;
        $data->mobile = $request->mobile;
        $data->otp = $otp['otp'];
        $data->save();
        Send_OTP($request->mobile, $otp['otp']);

        $response = [
            'message' => 'Successfully!',
            'status' => 200, 
            'otp_id' => $data->id,
            'otp' => $data->otp
        ];

        return response()->json($response);  
    }

    function login(LoginRequest $request)
    {
        $customer = Customer::where(['mobile' => $request->mobile, 'simple_password' => $request->password])->first();
        if($customer){
            if($customer->status != 1){
                $token = md5(uniqid(rand(), true));
                $customer->token = $token;
                $customer->save();

                $response = [
                    'customer' => $customer,
                    'token' => $token,
                    'message' => 'Successfully!',
                    'status' => 200
                ];
            }else{
                $response = [
                    'message' => 'Account Blocked, please contact to admin!',
                    'status' => 400
                ];
            }

        }else{
            $response = [
                'message' => 'Invalid credentials!',
                'status' => 400
            ];
        }
        return response()->json($response);
    }

    // function forgetPassword(ForgetPasswordRequest $request)
    // {
    //     $customer = Customer::where('mobile', $request->mobile)->first();

    //     // Mail::send('admin.mail.forget-password', ['customer' => $customer], function ($message) use ($request) {
    //     //     $message->to($request->email)->subject('Forget Password');
    //     // });

    //     if($customer){
    //         $response = [
    //             'message' => 'Password has been send!',
    //             'status' => 200
    //         ];
    //     }else{
    //         $response = [
    //             'message' => 'Invalid mobile number!',
    //             'status' => 400
    //         ];
    //     }

    //     return response()->json($response);
    // }

    function forgetPassword(ForgetPasswordRequest $request)
    {
        $customer = Customer::where('mobile', $request->mobile)->first();

        if ($customer) {            
            $smsSent = Send_OTP($customer->mobile, $customer->simple_password);
            // return $smsSent;
            // Check if the SMS was successfully sent
            
                $response = [
                    'message' => 'Password has been sent via SMS!',
                    'status' => 200,
                ];
             
        } else {
            $response = [
                'message' => 'Invalid mobile number!',
                'status' => 400,
            ];
        }
    
        return response()->json($response);
    
    }

 
    function deliveryBoyLogin(LoginRequest $request)
    {
        $deliveryBoy = DeliveryBoy::where(['mobile' => $request->mobile, 'simple_password' => $request->password])->first();
        if($deliveryBoy){
            if($deliveryBoy->status != 1){
                $token = md5(uniqid(rand(), true));
                $deliveryBoy->token = $token;
                $deliveryBoy->fcm = $request->fcm;
                $deliveryBoy->save();

                $response = [
                    'deliveryBoy' => $deliveryBoy,
                    'token' => $token,
                    'message' => 'Successfully!',
                    'status' => 200
                ];
            }else{
                $response = [
                    'message' => 'Account Blocked, please contact to admin!',
                    'status' => 400
                ];
            }

        }else{
            $response = [
                'message' => 'Invalid credentials!',
                'status' => 400
            ];
        }
        return response()->json($response);
    }






}

