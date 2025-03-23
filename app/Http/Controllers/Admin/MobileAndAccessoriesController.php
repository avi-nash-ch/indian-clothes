<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MobileAndAccessoriesProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class MobileAndAccessoriesController extends Controller
{
    
    public function index()
    {
        $mobileAndAccessoriesProducts = MobileAndAccessoriesProduct::leftJoin('products', 'products.id', 'mobile_and_accessories_products.product_id')
        ->where('mobile_and_accessories_products.deleted_at')
        ->whereNull('products.deleted_at')
        ->select('products.name', 'mobile_and_accessories_products.*')
        ->latest()
        ->get();

        return view('admin.mobileAndAccessories.index', compact('mobileAndAccessoriesProducts'));
    }

    public function create()
    {
        $products = Product::get();
        return view('admin.mobileAndAccessories.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $input = $request->except(['_token']);

        MobileAndAccessoriesProduct::create($input);
        return redirect()->route('mobileAndAccessories.index')->with('success', 'Product has been Added successfully.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $products = Product::get();
        $mobileAndAccessories = MobileAndAccessoriesProduct::where('id', $id)->first();

        return view('admin.mobileAndAccessories.edit', compact(['mobileAndAccessories', 'products']));
    }

    public function update(Request $request, $id)
    {
        $id =  decrypt($id);

        $request->validate([
            'product_id' => 'required',
        ]);

        $input = $request->except(['_token']);

        MobileAndAccessoriesProduct::where('id',$id)->update($input);

        return redirect()->route('mobileAndAccessories.index',)->with('success', 'Product has been Updated successfully');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        MobileAndAccessoriesProduct::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Product has been deleted successfully.');
    }
}
