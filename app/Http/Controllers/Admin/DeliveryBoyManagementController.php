<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryBoy;
use App\Models\Order;
use App\Models\DeliveryboyPaymentStatus;
use Illuminate\Http\Request;


class DeliveryBoyManagementController extends Controller
{
    public function index()
    {
        $deliveryboymanagements = DeliveryBoy::get();
        return view('admin.deliveryboy.index', compact('deliveryboymanagements'));
    }

    public function create()
    {
        return view('admin.deliveryboy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|digits:10',
            'password' => 'required',
            'address' => 'nullable',
            'adhar_no' => 'nullable',
            'delivery_charge' => 'nullable',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'license_no' => 'nullable|min:12|max:12', 
            'pan_no' => 'nullable|min:10|max:10',
            'vehicle_no' => 'nullable',
            'vehicle_desc' => 'nullable',
        ]);
    
        $input = $request->except(['_token']);
    
        if ($request->file('image')) {
            $file = $request->file('image');
            $path = 'admin/uploads/deliveryboy/'.time().$file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $input['image'] = $path;
            }
        }
        $input['password'] = bcrypt($request->password);
        $input['simple_password'] = $request->password;
    
        DeliveryBoy::create($input);
        return redirect()->route('delivery-boy-management.index')->with('success', 'Delivery Boy has been Added successfully.');
    }
    
    public function edit($id)
    {
        $id = decrypt($id);
        $deliveryboymanagements = DeliveryBoy::where('id', $id)->first();
        // return $deliveryboymanagements;
        return view('admin.deliveryboy.edit', compact('deliveryboymanagements'));
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
    
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|digits:10',
            'password' => 'required',
            'address' => 'nullable',
            'adhar_no' => 'nullable',
            'delivery_charge' => 'nullable',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'license_no' => 'nullable|min:12|max:12', 
            'pan_no' => 'nullable|min:10|max:10',
            'vehicle_no' => 'nullable',
            'vehicle_desc' => 'nullable',
        ]);
    
        $input = $request->except(['_token']);
    
        $deliveryboymanagements = DeliveryBoy::where('id', $id)->first();
    
        if ($request->file('image')) {
            deleteImage($deliveryboymanagements->image);
            $file = $request->file('image');
            $path = 'admin/uploads/deliveryboy/'.time().$file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $input['image'] = $path;
            }
        }
        $input['password'] = bcrypt($request->password);
        $input['simple_password'] = $request->password;
    
        DeliveryBoy::where('id', $id)->update($input);
    
        return redirect()->route('delivery-boy-management.index')->with('success', 'Delivery Boy has been Updated successfully');
    }
    

    public function delete($id)
    {

        $id = decrypt($id);
        DeliveryBoy::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Delivery Boy has been deleted successfully.');
    }

    public function payment($id)
    {
        $id = decrypt($id);
        $deliveryboy = DeliveryBoy::where('id', $id)->first();
        return view('admin.deliveryboy.payment', compact('deliveryboy'));
    }

    public function addPayment(Request $request, $id)
    {
        $id =  decrypt($id);

        $request->validate([
            'amount' => 'required',
        ]);

        $input = $request->except(['_token']);


        $deliveryboy = DeliveryBoy::where('id', $id)->first();
        $deliveryboy->wallet -= $request->amount;
        $deliveryboy->save();

        $deliveryBoyPaymentStatus = new DeliveryboyPaymentStatus();
        $deliveryBoyPaymentStatus->deliveryboy_id = $deliveryboy->id;
        $deliveryBoyPaymentStatus->amount = $request->amount;
        $deliveryBoyPaymentStatus->description = $request->description;
        $deliveryBoyPaymentStatus->save();

        return redirect()->route('delivery-boy-management.index',)->with('success', 'Delivery Boy Payment has been Updated successfully');
    }

    public function paymentHistory($id)
    {
        $id = decrypt($id);
        $paymentHistories = DeliveryboyPaymentStatus::leftJoin('delivery_boy_management', 'delivery_boy_management.id', 'deliveryboy_payment_statuses.deliveryboy_id')
        ->where('deliveryboy_id', $id)
        ->select('deliveryboy_payment_statuses.*', 'delivery_boy_management.name')
        ->get();

        return view('admin.deliveryboy.paymentHistory', compact('paymentHistories'));
    }

    public function getDeliveryBoys(Request $request)
    {
        $status = $request->delivery_boy_id;

        // Fetch delivery boys based on the provided status
        $deliveryBoys = DeliveryBoy::where('status', $status)->get();

        // Return the delivery boys as a JSON response
        return response()->json(['deliveryBoys' => $deliveryBoys]);
    }
    

    public function orders($id)
    {
        $id = decrypt($id);
        
        $orders = Order::leftJoin('customers', 'customers.id', 'orders.customer_id')
            ->where('delivery_boy_id', $id)->select('orders.*', 'customers.name', 'customers.mobile')
            ->latest()
            ->get();

        return view('admin.deliveryboy.order', compact('orders'));
    }
    public function view($id)
    {
        $id = decrypt($id);

        $deliveryboymanagements = DeliveryBoy::get();
        return view('admin.deliveryboy.view', compact('deliveryboymanagements'));
    }
}
