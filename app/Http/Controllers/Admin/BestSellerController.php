<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BestSeller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class BestSellerController extends Controller
{
    public function index()
    {
        $bestSellers = BestSeller::leftJoin('products', 'products.id', 'best_sellers.product_id')
        ->where('best_sellers.deleted_at')
        ->whereNull('products.deleted_at')
        ->select('products.name', 'best_sellers.*')
        ->latest()
        ->get();

        return view('admin.bestSeller.index', compact('bestSellers'));
    }

    public function create()
    {
        $products = Product::get();
        return view('admin.bestSeller.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $input = $request->except(['_token']);

        BestSeller::create($input);
        return redirect()->route('bestSeller.index')->with('success', 'Product has been Added successfully.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $products = Product::get();
        $bestSeller = BestSeller::where('id', $id)->first();

        return view('admin.bestSeller.edit', compact(['bestSeller', 'products']));
    }

    public function update(Request $request, $id)
    {
        $id =  decrypt($id);

        $request->validate([
            'product_id' => 'required',
        ]);

        $input = $request->except(['_token']);

        BestSeller::where('id',$id)->update($input);

        return redirect()->route('bestSeller.index',)->with('success', 'Product has been Updated successfully');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        BestSeller::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Product has been deleted successfully.');
    }
}
