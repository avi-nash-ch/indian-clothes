<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Customer;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\CustomerIdRequest;
use App\Http\Requests\IdRequest;
use Illuminate\Support\Facades\DB;


class AddressController extends Controller
{

    public function addressStore(AddressRequest $request)
    {
        $customer = Customer::where('id', $request->customer_id)->first();

        if ($customer) {
            // Check if pincode exists in the pincodes table
            // $pincodeExists = DB::table('pincodes')->where('pincode', $request->pincode)->exists();

            if ($customer) {
                $data = [
                    'customer_id' => $request->customer_id,
                    'house_address' => $request->house_address,
                    'street_address' => $request->street_address,
                    'landmark' => $request->landmark,
                    'locality' => $request->locality,
                    'pincode' => $request->pincode ?? '',
                    'lat' => $request->lat ?? '',
                    'long' => $request->long ?? '',
                ];
                $address = Address::create($data);

                $response = [
                    'message' => 'Created Successfully!',
                    'status' => 200
                ];
            } else {
                $response = [
                    'message' => 'Pincode does not exist!',
                    'status' => 400
                ];
            }
        } else {
            $response = [
                'message' => 'Something Went Wrong!',
                'status' => 400
            ];
        }

        return response()->json($response);
    }


    public function addresses(CustomerIdRequest $request)
    {
        $customer = Customer::where(['id' => $request->customer_id])->first();
        if($customer){
            $addresses = Address::where('customer_id', $request->customer_id)->latest()->get();
            $response = [
                'addresses' => $addresses,
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

    public function removeAddress(IdRequest $request)
    {
        $customer = Customer::where(['id' => $request->customer_id])->first();
        if($customer){

            $address = Address::where('id', $request->id)->delete();

            $addresses = Address::where('customer_id', $request->customer_id)->get();

            $response = [
                'addresses' => $addresses,
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
