<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\IdRequest;
use App\Models\SponsoredBanner;
use App\Models\SponsoredBannerProduct;

class SponsoredBannerProductController extends Controller
{
    // public function sponsoredBannerByProducts(IdRequest $request)
    // {
    //     $customerId = $request->customer_id;

    //     $products = SponsoredBannerProduct::join('products', 'products.id', 'sponsored_banner_products.product_id')
    //         ->join('units', 'units.id', 'products.unit_id')
    //         ->leftJoin('carts', function ($join) use ($customerId) {
    //             $join->on('carts.product_id', '=', 'products.id')
    //                 ->where('carts.customer_id', '=', $customerId);
    //         })
    //         ->where('sponsored_banner_products.banner_id', $request->id)
    //         ->select('products.*', 'units.name as unit', \DB::raw('CASE WHEN carts.deleted_at IS NOT NULL THEN NULL ELSE COALESCE(carts.quantity, null) END as cartQuantity'),)
    //         ->get();
        
    //         $response = [
    //             'products' => $products,
    //             'status' => 200
    //         ];
    
    //     return response()->json($response);
    // }


    public function sponsoredBannerByProducts(IdRequest $request)
    {
        $products = SponsoredBannerProduct::join('products', 'products.id', 'sponsored_banner_products.product_id')
            ->where('sponsored_banner_products.deleted_at')
            ->join('units', 'units.id', 'products.unit_id')
            ->select('products.*', 'units.name as unit')
            ->whereNull('products.deleted_at')
            ->where('sponsored_banner_products.banner_id', $request->id)
            ->get();

        $response = [
            'products' => $products,
            'status' => 200
        ];

        return response()->json($response);
    }

}
