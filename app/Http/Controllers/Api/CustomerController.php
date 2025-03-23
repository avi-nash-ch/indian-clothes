<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UpdateProfileRequest;

class CustomerController extends Controller
{
    function profile(ProfileRequest $request)
    {
        $customer = Customer::where(['id' => $request->customer_id])->first();
        // $token = $customer->createToken('my-app-token')->plainTextToken;
        if($customer){
            if($customer->status != 1){
                $response = [
                    'customer' => $customer,
                    'token' => $customer->token,
                    'message' => 'Successfully!',
                    'status' => 200
                ];
            }else{
                $response = [
                    'message' => 'Account Blocked, please contact to admin!',
                    'status' => 200
                ];
            }
        }else{
            $response = [
                'message' => 'Something went wrong!',
                'status' => 400
            ];
        }
        return response()->json($response);
    }

    function updateProfile(UpdateProfileRequest $request)
    {
        $customer = Customer::where(['id' => $request->customer_id])->first();
        
        // $token = $customer->createToken('my-app-token')->plainTextToken;
        if($customer){
            $data = [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'address' => $request->address,
                'password' => bcrypt($request->password),
                'simple_password' => $request->password,
            ];

            Customer::where('id', $request->customer_id)->update($data);
    
            $response = [
                'message' => 'Updated Successfully!',
                'status' => 200
            ];
        }else{
            $response = [
                'message' => 'Something Went Wrong!',
                'status' => 400
            ];
        }
        return response()->json($response);
    }
}
