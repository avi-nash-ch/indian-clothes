<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\IdRequest;
use App\Models\PromotionalBanner;
use App\Models\OfferProduct;

class OfferBannerProductController extends Controller
{
    // public function offerBannerByProducts(IdRequest $request)
    // {
    //     $customerId = $request->customer_id;

    //     $products = OfferProduct::join('products', 'products.id', 'offer_products.product_id')
    //         ->join('units', 'units.id', 'products.unit_id')
    //         ->leftJoin('carts', function ($join) use ($customerId) {
    //             $join->on('carts.product_id', '=', 'products.id')
    //                 ->where('carts.customer_id', '=', $customerId);
    //         })
    //         ->where('offer_products.offer_id', $request->id)
    //         ->select('products.*', 'units.name as unit', \DB::raw('CASE WHEN carts.deleted_at IS NOT NULL THEN NULL ELSE COALESCE(carts.quantity, null) END as cartQuantity'),)
    //         ->get();
        
    //         $response = [
    //             'products' => $products,
    //             'status' => 200
    //         ];
    
    //     return response()->json($response);
    // }

    public function offerBannerByProducts(IdRequest $request)
    {
        $products = OfferProduct::join('products', 'products.id', 'offer_products.product_id')
            ->join('units', 'units.id', 'products.unit_id')
            ->select('products.*', 'units.name as unit')
            ->where('offer_products.offer_id', $request->id)
            ->whereNull('products.deleted_at')
            ->get();

        $response = [
            'products' => $products,
            'status' => 200
        ];

        return response()->json($response);
    }
}
