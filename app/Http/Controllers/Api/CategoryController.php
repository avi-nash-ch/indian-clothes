<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Customer;
use App\Http\Requests\IdRequest;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function categoryByProducts(IdRequest $request)
    {
        // Check if customer exists
        $customer = Customer::where('id', $request->customer_id)->first();

        // Fetch category and its name
        $category = Category::where('id', $request->id)->first();
        $categoryName = $category ? $category->name : '';

        // Fetch subcategories
        $subCategories = SubCategory::where('category_id', $request->id)->get();

        if ($subCategories->count() > 0) {
            // If there are subcategories, return them
            $response = [
                'categoriesWithProducts' => $subCategories,
                'type' => 'subcategory',
                'categoryName' => $categoryName,
                'status' => 200
            ];
        } else {
            // Query for products in the category
            $categoriesWithProducts = Product::join('units', 'units.id', 'products.unit_id')
                ->leftJoin('carts', function ($join) use ($customer) {
                    $join->on('carts.product_id', '=', 'products.id');
                    if ($customer) {
                        $join->where('carts.customer_id', '=', $customer->id);
                    }
                })
                ->whereRaw("FIND_IN_SET($request->id, category_id)")
                ->select('products.*', 'units.name as unit')
                ->whereNull('products.deleted_at')
                ->addSelect(\DB::raw('COALESCE(carts.quantity, 0) as cartQuantity')) // Default to 0
                ->get();

            // Set cartQuantity to 0 for all products if customer is not logged in
            if (!$customer) {
                foreach ($categoriesWithProducts as $product) {
                    $product->cartQuantity = 0;
                }
            }

            $response = [
                'categoriesWithProducts' => $categoriesWithProducts,
                'categoryName' => $categoryName,
                'status' => 200
            ];
        }

        return response()->json($response);
    }


    public function subCategoryByProducts(IdRequest $request)
    {
        $subCategory = SubCategory::find($request->id);
        $categoryName = $subCategory ? $subCategory->name : '';

        $categoriesWithProducts = Product::join('units', 'units.id', 'products.unit_id')
            ->leftJoin('carts', function ($join) {
                // No longer checking for customer_id
                $join->on('carts.product_id', '=', 'products.id');
            })
            ->whereRaw("FIND_IN_SET($request->id, sub_category_id)")
            ->whereNull('products.deleted_at')
            ->select('products.*', 'units.name as unit', \DB::raw('CASE WHEN carts.deleted_at IS NOT NULL THEN NULL ELSE COALESCE(carts.quantity, null) END as cartQuantity'))
            ->get();

        $response = [
            'categoriesWithProducts' => $categoriesWithProducts,
            'categoryName' => $categoryName,
            'status' => 200
        ];

        return response()->json($response);
    }

    public function seeAllCategory()
    {
        // Fetch all categories that are not deleted (using soft delete functionality)
        $categories = Category::get();

        // Check if categories exist
        if ($categories->isNotEmpty()) {
            $response = [
                'categories' => $categories,
                'status' => 200
            ];  
        } else {
            $response = [
                'message' => 'No categories found',
                'status' => 404
            ];
        }

        // Return the categories as JSON response
        return response()->json($response);
    }


    
    // public function categoryByProducts(IdRequest $request)
    // {
    //     $customer = Customer::where(['id' => $request->customer_id])->first();
    //     if($customer){
    //         $customerId = $request->customer_id;

    //         $category = Category::where('id', $request->id)->first();
    //         $categoryName = '';
    //         if($category){
    //             $categoryName = $category->name;
    //         }

    //         $subCategories = SubCategory::where('category_id', $request->id)->get();
    //         if(count($subCategories) > 0){
    //             $categoriesWithProducts = SubCategory::where('category_id', $request->id)->get();

                
    //             $response = [
    //                 'categoriesWithProducts' => $categoriesWithProducts,
    //                 'type' => 'subcategory',
    //                 'categoryName' => $categoryName,
    //                 'status' => 200
    //             ];
    //         }else{
    //             $categoriesWithProducts = Product::join('units', 'units.id', 'products.unit_id')
    //                 ->leftJoin('carts', function ($join) use ($customerId) {
    //                     $join->on('carts.product_id', '=', 'products.id')
    //                         ->where('carts.customer_id', '=', $customerId);
    //                 })
    //                 ->whereRaw("FIND_IN_SET($request->id, category_id)")
    //                 ->select('products.*', 'units.name as unit', \DB::raw('CASE WHEN carts.deleted_at IS NOT NULL THEN NULL ELSE COALESCE(carts.quantity, null) END as cartQuantity'),)
    //                 ->get();
                
    //                 $response = [
    //                     'categoriesWithProducts' => $categoriesWithProducts,
    //                     'categoryName' => $categoryName,
    //                     'status' => 200
    //                 ];
    //         }
    //     }else{
    //         $response = [
    //             'message' => 'Something Went Wrong!',
    //             'status' => 400
    //         ];
    //     }
    
    //     return response()->json($response);
    // }


    // public function subCategoryByProducts(IdRequest $request)
    // {
    //     $customer = Customer::where(['id' => $request->customer_id])->first();
    //     if($customer){
    //         $customerId = $request->customer_id;

    //         $subCategory = SubCategory::where('id', $request->id)->first();
    //         $categoryName = '';
    //         if($subCategory){
    //             $categoryName = $subCategory->name;
    //         }

    //         $categoriesWithProducts = Product::join('units', 'units.id', 'products.unit_id')
    //             ->leftJoin('carts', function ($join) use ($customerId) {
    //                 $join->on('carts.product_id', '=', 'products.id')
    //                     ->where('carts.customer_id', '=', $customerId);
    //             })
    //             ->whereRaw("FIND_IN_SET($request->id, sub_category_id)")
    //             ->select('products.*', 'units.name as unit', \DB::raw('CASE WHEN carts.deleted_at IS NOT NULL THEN NULL ELSE COALESCE(carts.quantity, null) END as cartQuantity'),)
    //             ->get();
        
        
                
    //         $response = [
    //             'categoriesWithProducts' => $categoriesWithProducts,
    //             'categoryName' => $categoryName,
    //             'status' => 200
    //         ];
    //     }else{
    //         $response = [
    //             'message' => 'Something Went Wrong!',
    //             'status' => 400
    //         ];
    //     }
    //     return response()->json($response);
    // }
    

}
