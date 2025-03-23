<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\IdRequest;
use App\Models\PromotionalBanner;
use App\Models\PromotionalBannerProduct;

class PromotionalBannerProductController extends Controller
{
    // public function promotionalBannerByProducts(IdRequest $request)
    // {
    //     $products = PromotionalBannerProduct::join('products', 'products.id', 'promotional_banner_products.product_id')
    //         ->join('units', 'units.id', 'products.unit_id')
    //         ->select('products.*', 'units.name as unit')
    //         ->whereNull('products.deleted_at')
    //         ->where('promotional_banner_products.banner_id', $request->id)
    //         ->get();

    //     $response = [
    //         'products' => $products,
    //         'status' => 200
    //     ];

    //     return response()->json($response);
    // }

    public function promotionalBannerByProducts(IdRequest $request)
    {
        $customerId = $request->customer_id; // Get customer ID from request

        $products = PromotionalBannerProduct::join('products', 'products.id', 'promotional_banner_products.product_id')
            ->join('units', 'units.id', 'products.unit_id')
            ->leftJoin('carts', function ($join) use ($customerId) {
                $join->on('carts.product_id', '=', 'products.id')
                    ->where('carts.customer_id', '=', $customerId); // Filter by customer_id
            })
            ->select(
                'products.*',
                'units.name as unit',
                'carts.quantity as cartQuantity' // Get cart quantity
            )
            ->whereNull('products.deleted_at')
            ->where('promotional_banner_products.banner_id', $request->id)
            ->get();

        $response = [
            'products' => $products,
            'status' => 200
        ];

        return response()->json($response);
    }


}
