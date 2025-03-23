<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CouponCode;

class CouponCodeController extends Controller
{
    public function index()
    {
        $couponCodes = CouponCode::latest()->get();

        return view('admin.couponCode.index', compact('couponCodes'));
    }

    public function create()
    {
        return view('admin.couponCode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required',
            'offer' => 'required',
            'maximum_user' => 'required',
            'minimum_amount' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $input = $request->except(['_token']);

        CouponCode::create($input);
        return redirect()->route('couponCode.index')->with('success', 'Coupon Code has been Added successfully.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $couponCode = CouponCode::where('id', $id)->first();

        return view('admin.couponCode.edit', compact('couponCode'));
    }

    public function update(Request $request, $id)
    {
        $id =  decrypt($id);

        $request->validate([
            'coupon_code' => 'required',
            'offer' => 'required',
            'maximum_user' => 'required',
            'minimum_amount' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $input = $request->except(['_token']);

        CouponCode::where('id',$id)->update($input);

        return redirect()->route('couponCode.index',)->with('success', 'Coupon Code has been Updated successfully');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        CouponCode::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Coupon Code has been deleted successfully.');
    }
}
