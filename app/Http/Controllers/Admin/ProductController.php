<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::leftJoin('categories', 'categories.id', 'products.category_id')
        ->leftJoin('sub_categories', 'sub_categories.id', 'products.sub_category_id')
        ->leftJoin('units', 'units.id', 'products.unit_id')
        ->select('products.*', 'categories.name as category', 'sub_categories.name as subCategory', 'units.name as unitName')
        ->whereNull('products.deleted_at')  // Ensure deleted products are excluded.
        ->latest();

        if ($request->has('quantity')) {
            $products->where('quantity', ($request->quantity == 0) ? '=' : '<=', $request->quantity);
        }
    
        if(!empty($request->expiry_date)){
            $products->where('expiry_date', '<=', $request->expiry_date);
        }
        $products = $products->get();


        foreach($products as $product) {

            $product->category = '';
            if(!empty($product->category_id)) {
                $categoryId = explode(",",$product->category_id);
                $names = Category::whereIn('id', $categoryId)->select('categories.name')->get();
                $names = $names->pluck('name')->toArray();
                $product->category = implode(", ",$names);
            }

            $product->subCategory = '';
            if(!empty($product->sub_category_id)) {
                $subcategoryId = explode(",",$product->sub_category_id);
                $names = SubCategory::whereIn('id', $subcategoryId)->select('sub_categories.name')->get();
                $names = $names->pluck('name')->toArray();
                $product->subCategory = implode(", ",$names);
            }
        }
        return view('admin.product.index', compact('products'));
    }
    

//     public function index(Request $request)
// {
//     // Retrieve query parameters for filtering
//     $quantity = $request->input('quantity');
//     $expiry_date = $request->input('expiry_date');

//     // Build the query to filter products
//     $query = Product::query();

//     // Filter by quantity if provided
//     if (!empty($quantity)) {
//         $query->where('quantity', '<', $quantity);
//     }

//     // Filter by expiry date if provided
//     if (!empty($expiry_date)) {
//         $query->where('expiry_date', '<=', $expiry_date);
//     }

//     // Get the filtered products
//     $products = $query->get();

//     return view('admin.products.index', compact('products'));
// }

    public function create()
    {
        $categories = Category::get();
        $subCategories = SubCategory::get();
        $units = Unit::get();
        return view('admin.product.create', compact(['categories', 'subCategories','units']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            // 'sub_category_id' => 'required',
            'unit_id'=>'required',
            'name' => 'required',
            'description' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'quantity' => 'required',
            'tags' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg',
            'discount_price' => 'required',
        ]);
        

        $input = $request->except(['_token']);

        if ($request->file('image')) {
            $file = $request->file('image');
            $path = 'admin/uploads/product/'.time().$file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $input['image'] = $path;
            }
        }

        if ($request->hasFile('image1')) {
            $file1 = $request->file('image1');
            $path1 = 'admin/uploads/product/' . time() . '_' . $file1->getClientOriginalName();
            if (uploadImage($path1, $file1)) {
                $input['image1'] = $path1;
            }
        }


        if ($request->hasFile('image2')) {
            $file2 = $request->file('image2');
            $path2 = 'admin/uploads/product/' . time() . '_' . $file2->getClientOriginalName();
            if (uploadImage($path2, $file2)) {
                $input['image2'] = $path2;
            }
        }

        if ($request->hasFile('image3')) {
            $file3 = $request->file('image3');
            $path3 = 'admin/uploads/product/' . time() . '_' . $file3->getClientOriginalName();
            if (uploadImage($path3, $file3)) {
                $input['image3'] = $path3;
            }
        }

        if ($request->hasFile('image4')) {
            $file4 = $request->file('image4');
            $path4 = 'admin/uploads/product/' . time() . '_' . $file4->getClientOriginalName();
            if (uploadImage($path4, $file4)) {
                $input['image4'] = $path4;
            }
        }
        if(isset( $input['category_id']))
        {
            $input['category_id']=implode(",", $input['category_id']);
        }

        if(isset( $input['sub_category_id']))
        {
            $input['sub_category_id']=implode(",", $input['sub_category_id']);
        }

        Product::create($input);
        return redirect()->route('product.index')->with('success', 'Product has been Added successfully.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $categories = Category::get();
        $subCategories = SubCategory::get();
        $units = Unit::get();
        $product = Product::where('id', $id)->first();

        if(!empty($product->category_id)) {
            $product->category_id = explode("," ,$product->category_id);
        }
        else{
            $product->category_id = [];
        }

        if(!empty($product->sub_category_id)) {
            $product->sub_category_id = explode("," ,$product->sub_category_id);
        }
        else{
            $product->sub_category_id = [];
        }

        return view('admin.product.edit', compact(['product', 'categories', 'subCategories','units']));
    }

    // public function update(Request $request, $id)
    // {
    //     $id =  decrypt($id);

    //     $request->validate([
    //         'category_id' => 'required',
    //         'unit_id'=>'required',
    //         'name' => 'required',
    //         'description' => 'required',
    //         'purchase_price' => 'required',
    //         'sale_price' => 'required',
    //         'quantity' => 'required',
    //         'tags' => 'required',
    //         'image' => 'mimes:jpg,png,jpeg',
    //         'discount_price' => 'required',
    //     ]);

    //     $input = $request->except(['_token']);

    //     $product = Product::where('id', $id)->first();
    //     // return $product;
    //     if ($request->file('image')) {
    //         deleteImage($product->image);
    //         $file = $request->file('image');
    //         $path = 'admin/uploads/product/'.time().$file->getClientOriginalName();
    //         if (uploadImage($path, $file)) {
    //             $input['image'] = $path;
    //         }
    //     }


    //     if ($request->file('image1')) {
    //         deleteImage($product->image1);
    //         $file1 = $request->file('image1');
    //         $path1 = 'admin/uploads/product/' . time() . '_' . $file1->getClientOriginalName();
    //         if (uploadImage($path1, $file1)) {
    //             $input['image1'] = $path1;
    //         }
    //     }


    //     if ($request->file('image2')) {
    //         deleteImage($product->image2);
    //         $file2 = $request->file('image2');
    //         $path2 = 'admin/uploads/product/' . time() . '_' . $file2->getClientOriginalName();
    //         if (uploadImage($path2, $file2)) {
    //             $input['image2'] = $path2;
    //         }
    //     }


    //     if ($request->file('image3')) {
    //         deleteImage($product->image3);
    //         $file3 = $request->file('image3');
    //         $path3 = 'admin/uploads/product/' . time() . '_' . $file3->getClientOriginalName();
    //         if (uploadImage($path3, $file3)) {
    //             $input['image3'] = $path3;
    //         }
    //     }

    //     if ($request->file('image4')) {
    //         deleteImage($product->image4);
    //         $file4 = $request->file('image4');
    //         $path4 = 'admin/uploads/product/' . time() . '_' . $file4->getClientOriginalName();
    //         if (uploadImage($path4, $file4)) {
    //             $input['image4'] = $path4;
    //         }
    //     }

    //     if(empty($request->trending))
    //     {
    //         $input['trending']=0;
    //     }

    //     if(isset( $input['category_id']))
    //     {
    //         $input['category_id']=implode(",", $input['category_id']);
    //     }

    //     if(isset( $input['sub_category_id']))
    //     {
    //         $input['sub_category_id']=implode(",", $input['sub_category_id']);
    //     }else{
    //         $input['sub_category_id']= '';
    //     }


    //     Product::where('id',$id)->update($input);


    //     return redirect()->route('product.index',)->with('success', 'Product has been Updated successfully');
    // }


    public function update(Request $request, $id)
    {
        // Decrypting the ID
        $id = decrypt($id);

        // Validation rules
        $request->validate([
            'category_id' => 'required',
            'unit_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'tags' => 'required',
            'image' => 'nullable|mimes:jpg,png,jpeg|max:2048',  // Nullable and max size 1MB
            'image1' => 'nullable|mimes:jpg,png,jpeg|max:2048',
            'image2' => 'nullable|mimes:jpg,png,jpeg|max:2048',
            'image3' => 'nullable|mimes:jpg,png,jpeg|max:2048',
            'image4' => 'nullable|mimes:jpg,png,jpeg|max:2048',
            'discount_price' => 'required|numeric',
        ]);

        // Exclude token from input, process other form data
        $input = $request->except(['_token']);

        // Fetch the product from the database
        $product = Product::findOrFail($id);

        // Handle the image uploads and delete the old ones
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($product->image) {
                deleteImage($product->image);
            }

            $file = $request->file('image');
            $path = 'admin/uploads/product/' . time() . '_' . $file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $input['image'] = $path;
            }
        }

        if ($request->hasFile('image1')) {
            if ($product->image1) {
                deleteImage($product->image1);
            }

            $file1 = $request->file('image1');
            $path1 = 'admin/uploads/product/' . time() . '_' . $file1->getClientOriginalName();
            if (uploadImage($path1, $file1)) {
                $input['image1'] = $path1;
            }
        }

        if ($request->hasFile('image2')) {
            if ($product->image2) {
                deleteImage($product->image2);
            }

            $file2 = $request->file('image2');
            $path2 = 'admin/uploads/product/' . time() . '_' . $file2->getClientOriginalName();
            if (uploadImage($path2, $file2)) {
                $input['image2'] = $path2;
            }
        }

        if ($request->hasFile('image3')) {
            if ($product->image3) {
                deleteImage($product->image3);
            }

            $file3 = $request->file('image3');
            $path3 = 'admin/uploads/product/' . time() . '_' . $file3->getClientOriginalName();
            if (uploadImage($path3, $file3)) {
                $input['image3'] = $path3;
            }
        }

        if ($request->hasFile('image4')) {
            if ($product->image4) {
                deleteImage($product->image4);
            }

            $file4 = $request->file('image4');
            $path4 = 'admin/uploads/product/' . time() . '_' . $file4->getClientOriginalName();
            if (uploadImage($path4, $file4)) {
                $input['image4'] = $path4;
            }
        }

        // Handle checkbox for 'trending', set to 0 if not checked
        if (empty($request->trending)) {
            $input['trending'] = 0;
        } else {
            $input['trending'] = 1;
        }

        // Handle multi-select categories (convert to comma-separated string)
        if (isset($input['category_id'])) {
            $input['category_id'] = implode(",", $input['category_id']);
        }

        if (isset($input['sub_category_id'])) {
            $input['sub_category_id'] = implode(",", $input['sub_category_id']);
        } else {
            $input['sub_category_id'] = '';
        }

        // Update the product with the modified data
        $product->update($input);

        // Redirect back to product index with success message
        return redirect()->route('product.index')->with('success', 'Product has been updated successfully');
    }

    
    public function delete($id)
    {
        $id = decrypt($id);
        Product::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Product has been deleted successfully.');
    }

  // YourController.php
  public function removeImage(Request $request, $id)
  {
      $product = Product::findOrFail($id);
      $imageType = $request->imageType; // 'image', 'image1', 'image2', etc.
  
      if ($imageType && in_array($imageType, ['image', 'image1', 'image2', 'image3', 'image4'])) {
          $imageField = $imageType;
  
          // Remove the image from storage if it exists
          if ($product->$imageField) {
              Storage::delete('uploads/images/' . $product->$imageField); // Assuming your images are stored in 'uploads/images/'
              
              // Remove image from database
              $product->$imageField = null;
              $product->save();
  
              return response()->json(['success' => true]);
          }
      }
  
      return response()->json(['success' => false]);
  }

}
