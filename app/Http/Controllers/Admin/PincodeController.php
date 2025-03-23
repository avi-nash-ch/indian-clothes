<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pincode;

class PincodeController extends Controller
{
    //
    public function index()
    {
        $pincodes = Pincode::latest()->get();
        return view('admin.pincode.index', compact('pincodes'));
    }

    public function create()
    {
        return view('admin.pincode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pincode' => 'required|digits:6',
        ]);

        $input = $request->except(['_token']);

        Pincode::create($input);
        return redirect()->route('pincode.index')->with('success', 'Pincode has been Added successfully.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $pincode = Pincode::where('id', $id)->first();
        return view('admin.pincode.edit', compact('pincode'));
    }

    public function update(Request $request, $id)
    {
        $id =  decrypt($id);
        $request->validate([
            'pincode' => 'required|min:6|max:6',
        ]);

        $input = $request->except(['_token']);

        $pincode = Pincode::where('id', $id)->first();

        Pincode::where('id',$id)->update($input);

        return redirect()->route('pincode.index',)->with('success', 'Pincode has been Updated successfully');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        Pincode::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Pincode has been deleted successfully.');
    }
}
