<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SponsoredBanner;
use Illuminate\Http\Request;
use App\Models\SponsoredBannerProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SponsoredBannerController extends Controller
{
    public function index()
    {
        $sponsoredBanners = SponsoredBanner::latest()->get();
        return view('admin.sponsored-banner.index', compact('sponsoredBanners'));
    }

    public function create()
    {
        $products = Product::get();
        return view('admin.sponsored-banner.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg',
        ]);

        $input['name'] = $request->name;

        if ($request->file('image')) {
            $file = $request->file('image');
            $path = 'admin/uploads/sponsored-banner/'.time().$file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $input['image'] = $path;
            }
        }

        DB::beginTransaction();

        try {

            $sponsoredBanner = SponsoredBanner::create($input);

            $products = $request->input('product_ids', []);
            if (!empty($products)) {
                foreach ($products as $productId) {

                    if (is_numeric($productId) && $productId > 0) {
                        SponsoredBannerProduct::create([
                            'banner_id' => $sponsoredBanner->id,
                            'product_id' => $productId,
                        ]);
                    }
                }
            }
            DB::commit();

            return redirect()->route('sponsored-banner.index')->with('success', 'Sponsored Banner has been Added successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error occurred: ' . $e->getMessage())->withInput();
        }

    }

    public function edit($id)
    {
        $id = decrypt($id);
        $products = Product::get();
        $sponsoredBanner = SponsoredBanner::with('products')->findOrFail($id);
        $selectedProductIds = $sponsoredBanner->products ? $sponsoredBanner->products->pluck('product_id')->toArray() : [];

        return view('admin.sponsored-banner.edit', compact('sponsoredBanner', 'products', 'selectedProductIds'));
    }

    public function update(Request $request, $id)
    {
        $id =  decrypt($id);
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
        ]);

        $input = $request->except(['_token']);

        $sponsoredBanner = SponsoredBanner::where('id', $id)->first();

        if ($request->file('image')) {
            deleteImage($sponsoredBanner->image);
            $file = $request->file('image');
            $path = 'admin/uploads/sponsored-banner/'.time().$file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $input['image'] = $path;
            }
        }
        if($sponsoredBanner->update($input)) {

            $products = $request->product_ids;
            SponsoredBannerProduct::where('banner_id', $sponsoredBanner->id)->delete();
            if (!empty($products)) {
                foreach ($products as $productId) {
                    SponsoredBannerProduct::create([
                        'banner_id' => $sponsoredBanner->id,
                        'product_id' => $productId,
                    ]);
                }
            }
        }

        return redirect()->route('sponsored-banner.index',)->with('success', 'Sponsored Banner has been Updated successfully');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        SponsoredBanner::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Sponsored Banner has been deleted successfully.');
    }
}
