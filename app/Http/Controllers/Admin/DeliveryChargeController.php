<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryCharge;

class DeliveryChargeController extends Controller
{

    public function index()
    {
        $deliveryCharges = DeliveryCharge::latest()->get();
        return view('admin.delivery-charge.index', compact('deliveryCharges'));
    }

    public function create()
    {
        return view('admin.delivery-charge.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'min' => 'required',
            'max' => 'required',
            'delivery_charge' => 'required',
        ]);

        $input = $request->except(['_token']);

        DeliveryCharge::create($input);
        return redirect()->route('deliveryCharge.index')->with('success', 'Delivery Charge has been Added successfully.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $deliveryCharge = DeliveryCharge::where('id', $id)->first();
        return view('admin.delivery-charge.edit', compact('deliveryCharge'));
    }

    public function update(Request $request, $id)
    {
        $id =  decrypt($id);
        $request->validate([
            'min' => 'required',
            'max' => 'required',
            'delivery_charge' => 'required',
        ]);

        $input = $request->except(['_token']);

        $category = DeliveryCharge::where('id', $id)->first();

        DeliveryCharge::where('id',$id)->update($input);

        return redirect()->route('deliveryCharge.index',)->with('success', 'Delivery Charge has been Updated successfully');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        DeliveryCharge::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Delivery Charge has been deleted successfully.');
    }


}
