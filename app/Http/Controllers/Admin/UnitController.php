<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->get();
        return view('admin.unit.index', compact('units'));
    }

    public function create()
    {
        return view('admin.unit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $input = $request->except(['_token']);

        Unit::create($input);
        return redirect()->route('unit.index')->with('success', 'Unit has been Added successfully.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $unit = Unit::where('id', $id)->first();
        return view('admin.unit.edit', compact('unit'));
    }

    public function update(Request $request, $id)
    {
        $id =  decrypt($id);
        $request->validate([
            'name' => 'required',
        ]);

        $input = $request->except(['_token']);

        $unit = Unit::where('id', $id)->first();

        Unit::where('id',$id)->update($input);

        return redirect()->route('unit.index',)->with('success', 'Unit has been Updated successfully');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        Unit::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Unit has been deleted successfully.');
    }
}

