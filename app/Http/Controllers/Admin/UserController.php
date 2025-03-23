<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Address;

class UserController extends Controller
{
    public function index()
    {
        $users = Customer::latest()->get();
        return view('admin.user.index', compact('users'));
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $user = Customer::where('id', $id)->first();
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable',
            'email' => 'nullable',
            'mobile' => 'nullable',
        ]);


        $input = $request->all();
        unset($input['_token']);

        Customer::where('id',$id)->update($input);

        return redirect()->route('user.index')->with('success', 'User Updated successfully.');
    }

    public function view($id)
    {
        $id = decrypt($id);
        $userData = Customer::where('id', $id)->get();
        return view('admin.user.view', compact('userData'));
    }

    public function delete($id)
    {
        $id = decrypt($id);
        Customer::where('id', $id)->delete();
        return redirect()->back()->with('success', 'User has been deleted successfully.');
    }

    // public function block($id)
    // {
    //     $id = decrypt($id);
    //     $customer = Customer::where('id', $id)->first();
    //     if($customer){
    //         $type = '';
    //         if($customer->status == 0){
    //             $customer->status = 1;
    //             $customer->save();
    //             $type = 'blocked';
    //         }else{
    //             $customer->status = 0;
    //             $customer->save();
    //             $type = 'unblocked';

    //         }
    //         return redirect()->back()->with('success', 'User has been '. $type .' successfully.');
    //     }else{
    //         return redirect()->back()->with('error', 'Something went wrong.');
    //     }
    // }

    public function block($id)
    {
        $id = decrypt($id);
        $customer = Customer::where('id', $id)->first();
        
        if ($customer) {
            $type = '';
            
            if ($customer->status == 0) {
                $customer->status = 1;
                $token = md5(uniqid(rand(), true)); 
                $customer->token = $token;          
                $customer->save();
                $type = 'blocked';
            } 
            else {
                $customer->status = 0;
                $customer->token = null; 
                $customer->save();
                $type = 'unblocked';
            }
            
            return redirect()->back()->with('success', 'User has been '. $type .' successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }


    public function addressList($id)
    {
        $id = decrypt($id);
        $addresses = Address::where('customer_id', $id)->get();
        // echo '<pre>';
        // print_r($addresses);exit;
        return view('admin.user.address', compact('addresses'));
    }
}