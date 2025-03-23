<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PartyTimeProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class PartyTimeController extends Controller
{
    public function index()
    {
        $partyTimes = PartyTimeProduct::leftJoin('products', 'products.id', 'party_time_products.product_id')
        ->where('party_time_products.deleted_at')
        ->whereNull('products.deleted_at')
        ->select('products.name', 'party_time_products.*')
        ->latest()
        ->get();

        return view('admin.partyTime.index', compact('partyTimes'));
    }

    public function create()
    {
        $products = Product::get();
        return view('admin.partyTime.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $input = $request->except(['_token']);

        PartyTimeProduct::create($input);
        return redirect()->route('partyTime.index')->with('success', 'Product has been Added successfully.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $products = Product::get();
        $partyTime = PartyTimeProduct::where('id', $id)->first();

        return view('admin.partyTime.edit', compact(['partyTime', 'products']));
    }

    public function update(Request $request, $id)
    {
        $id =  decrypt($id);

        $request->validate([
            'product_id' => 'required',
        ]);

        $input = $request->except(['_token']);

        PartyTimeProduct::where('id',$id)->update($input);

        return redirect()->route('partyTime.index',)->with('success', 'Product has been Updated successfully');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        PartyTimeProduct::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Product has been deleted successfully.');
    }
}
