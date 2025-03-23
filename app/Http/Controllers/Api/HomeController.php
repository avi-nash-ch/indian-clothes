<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromotionalBanner;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Category;
use App\Models\BestSeller;
use App\Models\PartyTimeProduct;
use App\Models\MobileAndAccessoriesProduct;
use App\Models\SponsoredBanner;
use App\Models\SponsoredBannerProduct;
use App\Http\Requests\SeeAllRequest;
use App\Models\OfferBanner;

class HomeController
{
    public function home(Request $request)
    {
        // $customer = Customer::where('id', $request->customer_id)
        //     ->whereNull('deleted_at')
        //     ->first();

        // if ($customer) {
            $promotionalBanner = PromotionalBanner::latest()->get();

            // categoriesWithProducts
            $categoriesWithProducts = Category::get();
            $customerId = $request->customer_id;

            foreach ($categoriesWithProducts as $category) {
                $category->products = Product::join('units', 'units.id', 'products.unit_id')
                    ->leftJoin('carts', function ($join) use ($customerId) {
                        $join->on('carts.product_id', '=', 'products.id')
                            ->where('carts.customer_id', '=', $customerId)
                            ->whereNull('carts.deleted_at');
                    })
                    ->whereRaw("FIND_IN_SET($category->id, category_id)")
                    ->whereNull('products.deleted_at') // Exclude deleted products
                    ->select(
                        'products.*',
                        'units.name as unit',
                        \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'),
                        \DB::raw('CONCAT_WS(",", image, image1, image2, image3, image4) as images')
                    )
                    ->distinct()
                    ->get();

                foreach ($category->products as $product) {
                    $images = explode(',', $product->images);
                    $product->images = array_filter($images, function ($value) {
                        return !empty($value);
                    });
                }
            }

            // sponsoredBanner
            $sponsoredBanner = SponsoredBanner::latest()->whereNull('deleted_at')->get();

            // offerBanner
            $offerBanner = OfferBanner::latest()->get();

            $categories = Category::latest()->get();

            // bestSellers
            $bestSellers = BestSeller::join('products', 'products.id', 'best_sellers.product_id')
                ->where('best_sellers.deleted_at')
                ->whereNull('products.deleted_at')
                ->join('units', 'units.id', 'products.unit_id')
                ->leftJoin('carts', function ($join) use ($customerId) {
                    $join->on('carts.product_id', '=', 'best_sellers.product_id')
                        ->where('carts.customer_id', '=', $customerId)
                        ->whereNull('carts.deleted_at');
                })
                ->select('products.*', \DB::raw("'BestSeller' as type"), 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
                ->get();

            // exploreCategories
            $exploreCategories = Category::where('type', 1)->get();

            // shopByCategories
            $shopByCategories = Category::where('type', 2)->get();

            // partyTimeProducts
            $partyTimeProducts = PartyTimeProduct::join('products', 'products.id', 'party_time_products.product_id')
                ->where('party_time_products.deleted_at')
                ->whereNull('products.deleted_at')
                ->join('units', 'units.id', 'products.unit_id')
                ->leftJoin('carts', function ($join) use ($customerId) {
                    $join->on('carts.product_id', '=', 'party_time_products.product_id')
                        ->where('carts.customer_id', '=', $customerId)
                        ->whereNull('carts.deleted_at');
                })
                ->whereNull('products.deleted_at') // Exclude deleted products
                ->select('products.*', \DB::raw("'PartyTime' as type"), 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
                ->get();

            // mobileAndAccessoriesProducts
            $mobileAndAccessoriesProducts = MobileAndAccessoriesProduct::join('products', 'products.id', 'mobile_and_accessories_products.product_id')
                ->where('mobile_and_accessories_products.deleted_at')
                ->whereNull('products.deleted_at')
                ->join('units', 'units.id', 'products.unit_id')
                ->leftJoin('carts', function ($join) use ($customerId) {
                    $join->on('carts.product_id', '=', 'mobile_and_accessories_products.product_id')
                        ->where('carts.customer_id', '=', $customerId)
                        ->whereNull('carts.deleted_at');
                })
                ->whereNull('products.deleted_at') // Exclude deleted products
                ->select('products.*', \DB::raw("'MobileAndAccessories' as type"), 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
                ->get();

            // sponsoredBannerProduct
            $sponsoredBannerProduct = SponsoredBannerProduct::join('products', 'products.id', 'sponsored_banner_products.product_id')
                ->where('sponsored_banner_products.deleted_at')
                ->whereNull('products.deleted_at')
                ->join('units', 'units.id', 'products.unit_id')
                ->leftJoin('carts', function ($join) use ($customerId) {
                    $join->on('carts.product_id', '=', 'sponsored_banner_products.product_id')
                        ->where('carts.customer_id', '=', $customerId)
                        ->whereNull('carts.deleted_at');
                })
                ->whereNull('products.deleted_at') // Exclude deleted products
                ->select('products.*', \DB::raw("'Sponsored' as type"), 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
                ->distinct()
                ->get();

            // trending products
            $trendingProducts = Product::join('units', 'units.id', 'products.unit_id')
                ->leftJoin('carts', function ($join) use ($customerId) {
                    $join->on('carts.product_id', '=', 'products.id')
                        ->where('carts.customer_id', '=', $customerId)
                        ->whereNull('carts.deleted_at');
                })
                ->where('trending', 1)
                ->whereNull('products.deleted_at') // Exclude deleted products
                ->select('products.*', \DB::raw("'Trending' as type"), 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
                ->get();

            $response = [
                'promotionalBanner' => $promotionalBanner,
                'bestSellers' => $bestSellers,
                'exploreCategories' => $exploreCategories,
                'partyTimeProducts' => $partyTimeProducts,
                'sponsoredBanner' => $sponsoredBanner,
                'trendingProducts' => $trendingProducts,
                'sponsoredBannerProduct' => $sponsoredBannerProduct,
                'shopByCategories' => $shopByCategories,
                'mobileAndAccessoriesProducts' => $mobileAndAccessoriesProducts,
                'categoriesWithProducts' => $categoriesWithProducts,
                'offerBanner' => $offerBanner,
                'categories' => $categories,
                'status' => 200
            ];

        // } else {
        //     $response = [
        //         'message' => 'Something Went Wrong!',
        //         'status' => 400
        //     ];
        // }

        return response()->json($response);
    }
    // public function home(Request $request)
    // {
    //     $customerId = $request->customer_id;
    //     // Promotional Banner
    //     $promotionalBanner = PromotionalBanner::latest()->get();
    //     // Categories with Products
    //     $categoriesWithProducts = Category::get();

    //     foreach ($categoriesWithProducts as $category) {
    //         $category->products = Product::join('units', 'units.id', 'products.unit_id')
    //             ->leftJoin('carts', function ($join) use ($customerId) {
    //                 $join->on('carts.product_id', '=', 'products.id')
    //                     ->where('carts.customer_id', '=', $customerId)
    //                     ->whereNull('carts.deleted_at');
    //             })
    //             ->whereRaw("FIND_IN_SET($category->id, category_id)")
    //             ->active() // Use scope
    //             ->select(
    //                 'products.*',
    //                 'units.name as unit',
    //                 \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'),
    //                 \DB::raw('CONCAT_WS(",", image, image1, image2, image3, image4) as images')
    //             )
    //             ->distinct()
    //             ->get();

    //         foreach ($category->products as $product) {
    //             $images = explode(',', $product->images);
    //             $product->images = array_filter($images, fn($value) => !empty($value));
    //         }
    //     }

    //     // Sponsored Banner
    //     $sponsoredBanner = SponsoredBanner::latest()->whereNull('deleted_at')->get();

    //     // Offer Banner
    //     $offerBanner = OfferBanner::latest()->get();

    //     // Best Sellers
    //     $bestSellers = BestSeller::join('products', 'products.id', 'best_sellers.product_id')
    //         ->join('units', 'units.id', 'products.unit_id')
    //         ->leftJoin('carts', function ($join) use ($customerId) {
    //             $join->on('carts.product_id', '=', 'best_sellers.product_id')
    //                 ->where('carts.customer_id', '=', $customerId)
    //                 ->whereNull('carts.deleted_at');
    //         })
    //         ->active() // Use scope
    //         ->select('products.*', \DB::raw("'BestSeller' as type"), 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
    //         ->get();

    //     // Explore Categories
    //     $exploreCategories = Category::where('type', 1)->get();

    //     // Shop by Categories
    //     $shopByCategories = Category::where('type', 2)->get();

    //     // Party Time Products
    //     $partyTimeProducts = PartyTimeProduct::join('products', 'products.id', 'party_time_products.product_id')
    //         ->join('units', 'units.id', 'products.unit_id')
    //         ->leftJoin('carts', function ($join) use ($customerId) {
    //             $join->on('carts.product_id', '=', 'party_time_products.product_id')
    //                 ->where('carts.customer_id', '=', $customerId)
    //                 ->whereNull('carts.deleted_at');
    //         })
    //         ->active() // Use scope
    //         ->select('products.*', \DB::raw("'PartyTime' as type"), 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
    //         ->get();

    //     // Mobile and Accessories Products
    //     $mobileAndAccessoriesProducts = MobileAndAccessoriesProduct::join('products', 'products.id', 'mobile_and_accessories_products.product_id')
    //         ->join('units', 'units.id', 'products.unit_id')
    //         ->leftJoin('carts', function ($join) use ($customerId) {
    //             $join->on('carts.product_id', '=', 'mobile_and_accessories_products.product_id')
    //                 ->where('carts.customer_id', '=', $customerId)
    //                 ->whereNull('carts.deleted_at');
    //         })
    //         ->active() // Use scope
    //         ->select('products.*', \DB::raw("'MobileAndAccessories' as type"), 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
    //         ->get();

    //     // Sponsored Banner Products
    //     $sponsoredBannerProduct = SponsoredBannerProduct::join('products', 'products.id', 'sponsored_banner_products.product_id')
    //         ->join('units', 'units.id', 'products.unit_id')
    //         ->leftJoin('carts', function ($join) use ($customerId) {
    //             $join->on('carts.product_id', '=', 'sponsored_banner_products.product_id')
    //                 ->where('carts.customer_id', '=', $customerId)
    //                 ->whereNull('carts.deleted_at');
    //         })
    //         ->active() // Use scope
    //         ->select('products.*', \DB::raw("'Sponsored' as type"), 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
    //         ->distinct()
    //         ->get();

    //     // Trending Products
    //     $trendingProducts = Product::join('units', 'units.id', 'products.unit_id')
    //         ->leftJoin('carts', function ($join) use ($customerId) {
    //             $join->on('carts.product_id', '=', 'products.id')
    //                 ->where('carts.customer_id', '=', $customerId)
    //                 ->whereNull('carts.deleted_at');
    //         })
    //         ->where('trending', 1)
    //         ->active() // Use scope
    //         ->select('products.*', \DB::raw("'Trending' as type"), 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
    //         ->get();

    //     // Prepare Response
    //     $response = [
    //         'promotionalBanner' => $promotionalBanner,
    //         'bestSellers' => $bestSellers,
    //         'exploreCategories' => $exploreCategories,
    //         'partyTimeProducts' => $partyTimeProducts,
    //         'sponsoredBanner' => $sponsoredBanner,
    //         'trendingProducts' => $trendingProducts,
    //         'sponsoredBannerProduct' => $sponsoredBannerProduct,
    //         'shopByCategories' => $shopByCategories,
    //         'mobileAndAccessoriesProducts' => $mobileAndAccessoriesProducts,
    //         'categoriesWithProducts' => $categoriesWithProducts,
    //         'offerBanner' => $offerBanner,
    //         'categories' => Category::latest()->get(),
    //         'status' => 200
    //     ];

    //     return response()->json($response);
    // }


//     public function seeAll(SeeAllRequest $request)
//     {
//         $customer = Customer::where(['id' => $request->customer_id])->first();
//         $customerId = $request->customer_id;
//         if($customer){
//             if($request->type == 'BestSeller'){
//                 // bestSellers
//                 $bestSellers = BestSeller::join('products', 'products.id', 'best_sellers.product_id')
//                     ->join('units', 'units.id', 'products.unit_id')
//                     ->leftJoin('carts', function ($join) use ($customerId) {
//                         $join->on('carts.product_id', '=', 'best_sellers.product_id')
//                             ->where('carts.customer_id', '=', $customerId)
//                             ->whereNull('carts.deleted_at');
//                     })
//                     ->select('products.*', 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
//                     ->get();
// return $bestSellers;exit();
//                 $response = [
//                     'products' => $bestSellers,
//                     'status' => 200
//                 ];
//                 return response()->json($response);

//             }elseif($request->type == 'PartyTime'){

//                 $partyTimeProducts = PartyTimeProduct::join('products', 'products.id', 'party_time_products.product_id')
//                 ->join('units', 'units.id', 'products.unit_id')
//                 ->leftJoin('carts', function ($join) use ($customerId) {
//                     $join->on('carts.product_id', '=', 'party_time_products.product_id')
//                         ->where('carts.customer_id', '=', $customerId)
//                         ->whereNull('carts.deleted_at');
//                 })
//                 ->select('products.*', 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
//                 ->get();

//                 $response = [
//                     'products' => $partyTimeProducts,
//                     'status' => 200
//                 ];

//             }elseif($request->type == 'Trending'){

//                 // trending products
//                 $trendingProducts = Product::join('units', 'units.id', 'products.unit_id')
//                 ->leftJoin('carts', function ($join) use ($customerId) {
//                     $join->on('carts.product_id', '=', 'products.id')
//                         ->where('carts.customer_id', '=', $customerId)
//                         ->whereNull('carts.deleted_at');
//                 })
//                 ->where('trending', 1)
//                 ->select('products.*', 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
//                 ->get();

//                 $response = [
//                     'products' => $trendingProducts,
//                     'status' => 200
//                 ];

//             }elseif($request->type == 'Sponsored'){

//                 // sponsoredBannerProduct
//                 $sponsoredBannerProduct = SponsoredBannerProduct::join('products', 'products.id', 'sponsored_banner_products.product_id')
//                 ->join('units', 'units.id', 'products.unit_id')
//                 ->leftJoin('carts', function ($join) use ($customerId) {
//                     $join->on('carts.product_id', '=', 'sponsored_banner_products.product_id')
//                         ->where('carts.customer_id', '=', $customerId)
//                         ->whereNull('carts.deleted_at');
//                 })
//                 ->select('products.*', 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
//                 ->distinct()
//                 ->get();

//                 $response = [
//                     'products' => $sponsoredBannerProduct,
//                     'status' => 200
//                 ];

//             }elseif($request->type == 'MobileAndAccessories'){

//                 $mobileAndAccessoriesProducts = MobileAndAccessoriesProduct::join('products', 'products.id', 'mobile_and_accessories_products.product_id')
//                 ->join('units', 'units.id', 'products.unit_id')
//                 ->leftJoin('carts', function ($join) use ($customerId) {
//                     $join->on('carts.product_id', '=', 'mobile_and_accessories_products.product_id')
//                         ->where('carts.customer_id', '=', $customerId)
//                         ->whereNull('carts.deleted_at');
//                 })
//                 ->select('products.*', 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
//                 ->get();

//                 $response = [
//                     'products' => $mobileAndAccessoriesProducts,
//                     'status' => 200
//                 ];

//             }
//         }else{
//             $response = [
//                 'message' => 'Something Went Wrong!',
//                 'status' => 400
//             ];
//         }

//         return response()->json($response);
//     }

    

public function seeAll(SeeAllRequest $request)
{
    $customerId = $request->customer_id;
    $customer = Customer::find($customerId);

    // Default query to handle cartQuantity as 0 when customer is not found
    $cartCondition = function ($join) use ($customerId, $customer) {
        if ($customer) {
            $join->on('carts.product_id', '=', \DB::raw('products.id'))
                 ->where('carts.customer_id', '=', $customerId)
                 ->whereNull('carts.deleted_at');
        } else {
            $join->on(\DB::raw('1'), '=', \DB::raw('0')); // No cart entries
        }
    };

    switch ($request->type) {
        case 'BestSeller':
            $products = BestSeller::join('products', 'products.id', '=', 'best_sellers.product_id')
                ->where('best_sellers.deleted_at')
                ->whereNull('products.deleted_at')
                ->join('units', 'units.id', '=', 'products.unit_id')
                ->leftJoin('carts', $cartCondition)
                ->select('products.*', 'units.name as unit', \DB::raw('COALESCE(carts.quantity, 0) as cartQuantity'))
                ->get();
            break;

        case 'PartyTime':
            $products = PartyTimeProduct::join('products', 'products.id', '=', 'party_time_products.product_id')
                ->where('party_time_products.deleted_at')
                ->whereNull('products.deleted_at')
                ->join('units', 'units.id', '=', 'products.unit_id')
                ->leftJoin('carts', $cartCondition)
                ->select('products.*', 'units.name as unit', \DB::raw('COALESCE(carts.quantity, 0) as cartQuantity'))
                ->get();
            break;

        case 'Trending':
            $products = Product::join('units', 'units.id', '=', 'products.unit_id')
                ->leftJoin('carts', $cartCondition)
                ->where('trending', 1)
                ->whereNull('products.deleted_at')
                ->select('products.*', 'units.name as unit', \DB::raw('COALESCE(carts.quantity, 0) as cartQuantity'))
                ->get();
            break;

        case 'Sponsored':
            $products = SponsoredBannerProduct::join('products', 'products.id', '=', 'sponsored_banner_products.product_id')
                ->where('sponsored_banner_products.deleted_at')
                ->whereNull('products.deleted_at')
                ->join('units', 'units.id', '=', 'products.unit_id')
                ->leftJoin('carts', $cartCondition)
                ->select('products.*', 'units.name as unit', \DB::raw('COALESCE(carts.quantity, 0) as cartQuantity'))
                ->distinct()
                ->get();
            break;

        case 'MobileAndAccessories':
            $products = MobileAndAccessoriesProduct::join('products', 'products.id', '=', 'mobile_and_accessories_products.product_id')
                ->where('mobile_and_accessories_products.deleted_at')
                ->whereNull('products.deleted_at')
                ->join('units', 'units.id', '=', 'products.unit_id')
                ->leftJoin('carts', $cartCondition)
                ->select('products.*', 'units.name as unit', \DB::raw('COALESCE(carts.quantity, 0) as cartQuantity'))
                ->get();
            break;

        default:
            return response()->json(['message' => 'Invalid type specified.', 'status' => 400]);
    }

    return response()->json(['products' => $products, 'status' => 200]);
}


// public function seeAll(SeeAllRequest $request)
    // {
    //     // Initialize the response
    //     $response = [
    //         'products' => [],
    //         'status' => 200
    //     ];

    //     // Check the request type
    //     if ($request->type == 'BestSeller') {
    //         // Get best seller products
    //         $bestSellers = BestSeller::join('products', 'products.id', 'best_sellers.product_id')
    //             ->join('units', 'units.id', 'products.unit_id')
    //             ->select('products.*', 'units.name as unit')
    //             ->get();

    //         $response['products'] = $bestSellers;

    //     } elseif ($request->type == 'PartyTime') {
    //         // Get party time products
    //         $partyTimeProducts = PartyTimeProduct::join('products', 'products.id', 'party_time_products.product_id')
    //             ->join('units', 'units.id', 'products.unit_id')
    //             ->select('products.*', 'units.name as unit')
    //             ->get();

    //         $response['products'] = $partyTimeProducts;

    //     } elseif ($request->type == 'Trending') {
    //         // Get trending products
    //         $trendingProducts = Product::join('units', 'units.id', 'products.unit_id')
    //             ->where('trending', 1)
    //             ->select('products.*', 'units.name as unit')
    //             ->get();

    //         $response['products'] = $trendingProducts;

    //     } elseif ($request->type == 'Sponsored') {
    //         // Get sponsored banner products
    //         $sponsoredBannerProduct = SponsoredBannerProduct::join('products', 'products.id', 'sponsored_banner_products.product_id')
    //             ->join('units', 'units.id', 'products.unit_id')
    //             ->select('products.*', 'units.name as unit')
    //             ->distinct()
    //             ->get();

    //         $response['products'] = $sponsoredBannerProduct;

    //     } elseif ($request->type == 'MobileAndAccessories') {
    //         // Get mobile and accessories products
    //         $mobileAndAccessoriesProducts = MobileAndAccessoriesProduct::join('products', 'products.id', 'mobile_and_accessories_products.product_id')
    //             ->join('units', 'units.id', 'products.unit_id')
    //             ->select('products.*', 'units.name as unit')
    //             ->get();

    //         $response['products'] = $mobileAndAccessoriesProducts;

    //     } else {
    //         // Invalid type or type not found
    //         $response = [
    //             'message' => 'Invalid product type!',
    //             'status' => 400
    //         ];
    //     }

        // Return the response as JSON
    //     return response()->json($response);
    // }
}
