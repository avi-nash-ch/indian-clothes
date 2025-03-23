<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromotionalBanner;
use App\Models\PromotionalBannerProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class PromotionalBannerController extends Controller
{
    public function index()
    {
        $promotionalBanners = PromotionalBanner::latest()->get();
        return view('admin.promotional-banner.index', compact('promotionalBanners'));
    }

    public function create()
    {
        $products = Product::get();
        return view('admin.promotional-banner.create', compact('products'));
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
            $path = 'admin/uploads/promotional-banner/'.time().$file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $input['image'] = $path;
            }
        }

        DB::beginTransaction();

        try {

            $promotionalBanner = PromotionalBanner::create($input);

            $products = $request->input('product_ids', []);
            if (!empty($products)) {
                foreach ($products as $productId) {

                    if (is_numeric($productId) && $productId > 0) {
                        PromotionalBannerProduct::create([
                            'banner_id' => $promotionalBanner->id,
                            'product_id' => $productId,
                        ]);
                    }
                }
            }
            DB::commit();

            return redirect()->route('promotionalBanner.index')->with('success', 'Promotional Banner has been Added successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error occurred: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $products = Product::get();
        $promotionalBanner = PromotionalBanner::with('products')->findOrFail($id);
        $selectedProductIds = $promotionalBanner->products ? $promotionalBanner->products->pluck('product_id')->toArray() : [];

        return view('admin.promotional-banner.edit', compact('promotionalBanner', 'products', 'selectedProductIds'));
    }

    public function update(Request $request, $id)
    {
        $id =  decrypt($id);
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
        ]);
        
        $input = $request->except(['_token']);
        
        $promotionalBanner = PromotionalBanner::where('id', $id)->first();

        if ($request->file('image')) {
            deleteImage($promotionalBanner->image);
            $file = $request->file('image');
            $path = 'admin/uploads/promotional-banner/'.time().$file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $input['image'] = $path;
            }
        }

        if($promotionalBanner->update($input)) {

            $products = $request->product_ids;
            PromotionalBannerProduct::where('banner_id', $promotionalBanner->id)->delete();
            if (!empty($products)) {
                foreach ($products as $productId) {
                    PromotionalBannerProduct::create([
                        'banner_id' => $promotionalBanner->id,
                        'product_id' => $productId,
                    ]);
                }
            }
        }

        return redirect()->route('promotionalBanner.index',)->with('success', 'Promotional Banner has been Updated successfully');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        PromotionalBanner::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Promotional Banner has been deleted successfully.');
    }
}
