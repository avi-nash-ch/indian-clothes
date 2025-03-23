<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OfferBanner;
use App\Models\OfferProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OfferBannerController extends Controller
{
    public function index()
    {
        $offerBanners = OfferBanner::latest()->get();
        return view('admin.offer-banner.index', compact('offerBanners'));
    }

    public function create()
    {

        $products = Product::get();
        return view('admin.offer-banner.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        // Extract input data
        $input = $request->except(['_token', 'products']);

        // Upload image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'admin/uploads/offer-banner/' . time() . $file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $input['image'] = $path;
            }
        }

        DB::beginTransaction();

        try {

            $offerBanner = OfferBanner::create($input);

            $products = $request->input('product_ids', []);
            if (!empty($products)) {
                foreach ($products as $productId) {

                    if (is_numeric($productId) && $productId > 0) {
                        OfferProduct::create([
                            'offer_id' => $offerBanner->id,
                            'product_id' => $productId,
                        ]);
                    }
                }
            }
            DB::commit();

            return redirect()->route('offerBanner.index')->with('success', 'Offer Banner has been Added successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error occurred: ' . $e->getMessage())->withInput();
        }

}


    public function edit($id)
    {
            $id = decrypt($id);
            $products = Product::get();
            $offerBanner = OfferBanner::with('products')->findOrFail($id);
            $selectedProductIds = $offerBanner->products ? $offerBanner->products->pluck('product_id')->toArray() : [];


            return view('admin.offer-banner.edit', compact('offerBanner', 'products', 'selectedProductIds'));
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
        ]);

        $input = $request->except(['_token']);
        $offerBanner = OfferBanner::findOrFail($id);
        if ($request->file('image')) {
            deleteImage($offerBanner->image);
            $file = $request->file('image');
            $path = 'admin/uploads/offer-banner/' . time() . $file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $input['image'] = $path;
            }
        }
        if($offerBanner->update($input)) {

            $products = $request->product_ids;
            OfferProduct::where('offer_id', $offerBanner->id)->delete();
            if (!empty($products)) {
                foreach ($products as $productId) {
                    OfferProduct::create([
                        'offer_id' => $offerBanner->id,
                        'product_id' => $productId,
                    ]);
                }
            }
        }
        return redirect()->route('offerBanner.index')->with('success', 'Offer Banner has been updated successfully');


    }

    public function delete($id)
    {
        $id = decrypt($id);
        OfferBanner::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Offer Banner has been deleted successfully.');
    }
}

