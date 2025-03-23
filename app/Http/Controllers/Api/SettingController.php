<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Setting;
use App\Http\Requests\CustomerIdRequest;

class SettingController extends Controller
{
    function setting(CustomerIdRequest $request)
    {
        // $customer = Customer::where(['id' => $request->customer_id])->first();
        // if($customer){
            $setting = Setting::first();
            if($setting){

                $response = [
                    'data' => $setting,
                    'status' => 200
                ];
            } else{
                $response = [
                    'message' => 'Something went wrong!',
                    'status' => 400
                ];
            }
        // } else{
        //     $response = [
        //         'message' => 'Something went wrong!',
        //         'status' => 400
        //     ];
        // }

        return response()->json($response);
    }
}
