<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\IdRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Product;
use App\Models\RecentSearch;
use App\Models\Category;
use Carbon\Carbon;

class ProductController extends Controller
{
    // public function products(IdRequest $request)
    // {
    //     $customerId = $request->customer_id; // Customer ID from the request
    //     $currentDate = Carbon::now();
    
    //     // Base query for fetching the product with category, subcategory, and unit
    //     $productsQuery = Product::leftJoin('categories', 'categories.id', 'products.category_id')
    //         ->leftJoin('sub_categories', 'sub_categories.id', 'products.sub_category_id')
    //         ->leftJoin('units', 'units.id', 'products.unit_id')
    //         ->where('products.id', $request->id)
    //         ->whereNull('products.deleted_at')
    //         // ->where(function($q) use ($currentDate) {
    //         //     $q->whereDate('products.expiry_date', '>=', $currentDate)
    //         //     ->orWhereNull('products.expiry_date');
    //         // })
    //         ->select('products.*', 'categories.name as category', 'sub_categories.name as subCategory', 'units.name as unit');

    //     // If the customer is logged in, include cart quantity, otherwise set cartQuantity to 0
    //     if ($customerId) {
    //         $productsQuery->leftJoin('carts', function ($join) use ($customerId) {
    //             $join->on('carts.product_id', '=', 'products.id')
    //                 ->where('carts.customer_id', '=', $customerId)
    //                 ->whereNull('carts.deleted_at');
    //         })
    //         ->addSelect(\DB::raw('COALESCE(carts.quantity, 0) as cartQuantity'));
    //     } else {
    //         // Set cartQuantity to 0 when customer is not logged in
    //         $productsQuery->addSelect(\DB::raw('0 as cartQuantity'));
    //     }

    //     $products = $productsQuery->first();

    //     // Fetch the main product to retrieve its category ID
    //     $product = Product::where('id', $request->id)
    //         ->whereNull('deleted_at') 
    //         ->first();

    //     // Similar products query (without considering cart quantity)
    //     $similarProductsQuery = Product::join('categories', 'categories.id', 'products.category_id')
    //         ->where('category_id', $product->category_id)
    //         ->where('products.id', '!=', $request->id)
    //         ->whereNull('products.deleted_at')
    //         // ->where(function($q) use ($currentDate) {
    //         //     $q->whereDate('products.expiry_date', '>=', $currentDate)
    //         //     ->orWhereNull('products.expiry_date');
    //         // })
    //         ->select('products.*', 'categories.name as category');
    
    //     // If customer is logged in, include cart quantity for similar products, otherwise set cartQuantity to 0
    //     if ($customerId) {
    //         $similarProductsQuery->leftJoin('carts', function ($join) use ($customerId) {
    //             $join->on('carts.product_id', '=', 'products.id')
    //                 ->where('carts.customer_id', '=', $customerId)
    //                 ->whereNull('carts.deleted_at');
    //         })
    //         ->addSelect(\DB::raw('COALESCE(carts.quantity, 0) as cartQuantity'));
    //     } else {
    //         // Set cartQuantity to 0 when customer is not logged in
    //         $similarProductsQuery->addSelect(\DB::raw('0 as cartQuantity'));
    //     }
    
    //     $similarProducts = $similarProductsQuery->get();
    
    //     // If the product has multiple categories, handle them
    //     if (!empty($product->category_id)) {
    //         $product->category_id = explode(",", $product->category_id);
    //     }
    
    //     // Fetch similar categories
    //     $similarCategories = [];
    //     foreach ($product->category_id as $categoryId) {
    //         $category = Category::find($categoryId);
    //         if ($category) {
    //             $similarCategories[] = $category;
    //         }
    //     }
    
    //     // Prepare the response
    //     $response = [
    //         'products' => $products,
    //         'similarProducts' => $similarProducts,
    //         'similarCategories' => $similarCategories,
    //         'status' => 200
    //     ];

    //     return response()->json($response);
    // }

    public function products(IdRequest $request)
    {
        $customerId = $request->customer_id; // Customer ID from the request
        $currentDate = Carbon::now();

        // Base query for fetching the product with category, subcategory, and unit
        $productsQuery = Product::leftJoin('categories', 'categories.id', 'products.category_id')
            ->leftJoin('sub_categories', 'sub_categories.id', 'products.sub_category_id')
            ->leftJoin('units', 'units.id', 'products.unit_id')
            ->where('products.id', $request->id)
            ->whereNull('products.deleted_at')
            ->select('products.*', 'categories.name as category', 'sub_categories.name as subCategory', 'units.name as unit');

        // Handle cart quantity based on the customer ID
        if ($customerId) {
            $productsQuery->leftJoin('carts', function ($join) use ($customerId) {
                $join->on('carts.product_id', '=', 'products.id')
                    ->where('carts.customer_id', '=', $customerId)
                    ->whereNull('carts.deleted_at');
            })
            ->addSelect(\DB::raw('COALESCE(carts.quantity, 0) as cartQuantity'));
        } else {
            $productsQuery->addSelect(\DB::raw('0 as cartQuantity'));
        }

        $products = $productsQuery->first();

        // Fetch the main product to retrieve its category ID
        $product = Product::where('id', $request->id)
            ->whereNull('deleted_at') 
            ->first();

        // Ensure the product exists
        if (!$product) {
            return response()->json([
                'message' => 'Product not found!',
                'status' => 404
            ]);
        }

        // Similar products query
        $similarProductsQuery = Product::join('categories', 'categories.id', 'products.category_id')
            ->where('products.category_id', $product->category_id)
            ->where('products.id', '!=', $request->id)
            ->whereNull('products.deleted_at')
            ->select('products.*', 'categories.name as category');

        if ($customerId) {
            $similarProductsQuery->leftJoin('carts', function ($join) use ($customerId) {
                $join->on('carts.product_id', '=', 'products.id')
                    ->where('carts.customer_id', '=', $customerId)
                    ->whereNull('carts.deleted_at');
            })
            ->addSelect(\DB::raw('COALESCE(carts.quantity, 0) as cartQuantity'));
        } else {
            $similarProductsQuery->addSelect(\DB::raw('0 as cartQuantity'));
        }

        $similarProducts = $similarProductsQuery->get();

        // Fetch similar categories
        $similarCategories = [];
        $categoryIds = explode(",", (string) $product->category_id);
        foreach ($categoryIds as $categoryId) {
            $category = Category::find(trim($categoryId));
            if ($category) {
                $similarCategories[] = $category;
            }
        }

        // Prepare the response
        $response = [
            'products' => $products,
            'similarProducts' => $similarProducts,
            'similarCategories' => $similarCategories,
            'status' => 200
        ];

        return response()->json($response);
    }

    

    // public function search(SearchRequest $request)
    // {
    //     $keyword = $request->tags;

    //     // Step 1: Get matching product IDs based on tags from the products table
    //     $matchingProductIds = Product::select('products.id')
    //         ->where('products.tags', 'LIKE', '%' . $keyword . '%') // Search based on tags within the products table
    //         ->whereNull('products.deleted_at')
    //         ->pluck('products.id');

    //     // Step 2: Get the product details
    //     $products = Product::leftJoin('categories', 'categories.id', 'products.category_id')
    //         ->leftJoin('sub_categories', 'sub_categories.id', 'products.sub_category_id')
    //         ->leftJoin('units', 'units.id', 'products.unit_id')
    //         ->whereIn('products.id', $matchingProductIds)
    //         ->whereNull('products.deleted_at')
    //         ->select('products.*', 'categories.name as category_name', 'sub_categories.name as sub_category_name', 'units.name as unit')
    //         ->get();

    //     // Step 3: Return the response
    //     $response = [
    //         'products' => $products,
    //         'status' => 200
    //     ];

    //     return response()->json($response);
    // }

    public function search(SearchRequest $request)
{
    $keyword = $request->tags;
    $customerId = $request->customer_id; // Get customer ID from request

    // Step 1: Get matching product IDs based on tags from the products table
    $matchingProductIds = Product::select('products.id')
        ->where('products.tags', 'LIKE', '%' . $keyword . '%')
        ->whereNull('products.deleted_at')
        ->pluck('products.id');

    // Step 2: Get the product details along with cart quantity
    $products = Product::leftJoin('categories', 'categories.id', 'products.category_id')
        ->leftJoin('sub_categories', 'sub_categories.id', 'products.sub_category_id')
        ->leftJoin('units', 'units.id', 'products.unit_id')
        ->leftJoin('carts', function ($join) use ($customerId) {
            $join->on('carts.product_id', '=', 'products.id')
                ->where('carts.customer_id', '=', $customerId); // Filter by customer_id
        })
        ->whereIn('products.id', $matchingProductIds)
        ->whereNull('products.deleted_at')
        ->select(
            'products.*', 
            'categories.name as category_name', 
            'sub_categories.name as sub_category_name', 
            'units.name as unit',
            'carts.quantity as cartQuantity'
        )
        ->get();

    // Step 3: Return the response
    $response = [
        'products' => $products,
        'status' => 200
    ];

    return response()->json($response);
}


    public function recentSearch(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'search_term' => 'required|string|max:255',
        ]);

        // Check if the search term already exists for the customer
        $existingSearch = RecentSearch::where('customer_id', $request->customer_id)
                                    ->where('search_term', $request->search_term)
                                    ->first();

        if ($existingSearch) {
            $response = [
                'message' => 'Search term already exists for this customer.',
                'recent_search' => $existingSearch,
                'status' => 200
            ];
        } else {
            // Save the new search term
            $recentSearch = RecentSearch::create([
                'customer_id' => $request->customer_id,
                'search_term' => $request->search_term,
            ]);

            $response = [
                'message' => 'Search term stored successfully.',
                'recent_search' => $recentSearch,
                'status' => 200
            ];
        }

        return response()->json($response);
    }

    public function getRecentSearches(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
        ]);

        $recentSearches = RecentSearch::where('customer_id', $request->customer_id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    // return $recentSearches;
        return response()->json([
            'recent_searches' => $recentSearches,
            'status' => 200
        ]);
    }


    public function clearRecentSearches(Request $request)
        {
            $request->validate([
                'customer_id' => 'required',
            ]);

            RecentSearch::where('customer_id', $request->customer_id)->delete();

            return response()->json([
                'recent_searches' => [],
                'message' => 'Recent searches cleared successfully.',
                'status' => 200
            ]);
        }


    // public function products(IdRequest $request)
    // {
    //     $customerId = $request->customer_id;
    //     $currentDate = Carbon::now();
    //     $products = Product::leftJoin('categories', 'categories.id', 'products.category_id')
    //         ->leftJoin('sub_categories', 'sub_categories.id', 'products.sub_category_id')
    //         ->leftJoin('units', 'units.id', 'products.unit_id')
    //         ->leftJoin('carts', function ($join) use ($customerId) {
    //             $join->on('carts.product_id', '=', 'products.id')
    //                 ->where('carts.customer_id', '=', $customerId)
    //                 ->whereNull('carts.deleted_at');
    //         })
    //         ->where('products.id', $request->id)
    //         // ->where(function($q) use ($currentDate) {
    //         //     $q->whereDate('products.expiry_date', '>=', $currentDate)
    //         //     ->orWhereNull('products.expiry_date');
    //         // })
    //          // Filter out expired products
    //         ->select('products.*', 'categories.name as category', 'sub_categories.name as subCategory', 'units.name as unit', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
    //         ->first();

    //     $product = Product::where('id', $request->id)
    //         ->whereNull('deleted_at') 
    //         ->first();

    //     $similarProducts = Product::join('categories', 'categories.id', 'products.id')
    //         ->leftJoin('carts', function ($join) use ($customerId) {
    //             $join->on('carts.product_id', '=', 'products.id')
    //                 ->where('carts.customer_id', '=', $customerId)
    //                 ->whereNull('carts.deleted_at');
    //         })
    //         ->where('category_id', $product->category_id)
    //         ->where('products.id', '!=' ,$request->id)
    //         // ->where(function($q) use ($currentDate) {
    //         //     $q->whereDate('products.expiry_date', '>=', $currentDate)
    //         //     ->orWhereNull('products.expiry_date');
    //         // })
    //          // Filter out expired products
    //         ->select('products.*', 'categories.name as category', \DB::raw('COALESCE(carts.quantity, null) as cartQuantity'))
    //         ->get();

    //     if(!empty($product->category_id)) {
    //         $product->category_id = explode("," ,$product->category_id);
    //     }

    //     $similarCategories = [];

    //     foreach ($product->category_id as $categoryId) {
    //         $category = Category::find($categoryId);

    //         if ($category) {
    //             $similarCategories[] = $category;
    //         }
    //     }

    //     $response = [
    //         'products' => $products,
    //         'similarProducts' => $similarProducts,
    //         'similarCategories' => $similarCategories,
    //         'status' => 200
    //     ];

    //     return response()->json($response);
    // }
    
    // public function search(SearchRequest $request)
    // {
    //     $keyword = $request->tags;
    //     $customerId = $request->customer_id;
    
    //     // Step 1: Get matching product IDs based on tags from the products table
    //     $matchingProductIds = Product::select('products.id')
    //         ->where('products.tags', 'LIKE', '%' . $keyword . '%') // Search based on tags within the products table
    //         ->pluck('products.id');
    
    //     // Step 2: Get the product details
    //     $products = Product::leftJoin('categories', 'categories.id', 'products.category_id')
    //         ->leftJoin('sub_categories', 'sub_categories.id', 'products.sub_category_id')
    //         ->leftJoin('units', 'units.id', 'products.unit_id')
    //         ->leftJoin('carts', function ($join) use ($customerId) {
    //             $join->on('carts.product_id', '=', 'products.id')
    //                 ->where('carts.customer_id', '=', $customerId)
    //                 ->whereNull('carts.deleted_at');
    //         })
    //         ->whereIn('products.id', $matchingProductIds)
    //         ->select('products.*', 'categories.name as category_name', 'sub_categories.name as sub_category_name', 'carts.quantity as cartQuantity', 'units.name as unit')
    //         ->get();
    
    //     // Step 3: Return the response
    //     $response = [
    //         'products' => $products,
    //         'status' => 200
    //     ];
    
    //     return response()->json($response);
    // }

}
