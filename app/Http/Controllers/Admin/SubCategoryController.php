<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::leftJoin('categories', 'categories.id', 'sub_categories.category_id')
            ->select('sub_categories.*', 'categories.name as category')
            ->latest()
            ->get();
        return view('admin.sub-category.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::get();
        return view('admin.sub-category.create', compact('categories'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'category_id' => 'required',
    //         'name' => 'required',
    //     ]);

    //     $input = $request->except(['_token']);

    //     SubCategory::create($input);
    //     return redirect()->route('subCategory.index')->with('success', 'Sub Category has been Added successfully.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'image' => 'nullable|mimes:jpg,png,jpeg'
        ]);
        
        if ($request->file('image')) {
            $file = $request->file('image');
            $path = 'admin/uploads/category/'.time().$file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $image = $path;
            }
        }
        $input = $request->except(['_token']);

        $sub_category = new SubCategory();
        $sub_category->category_id = $request->category_id;  // Save the category_id
        $sub_category->name = $request->name;
        $sub_category->image = $image;
        $sub_category->save();

        return redirect()->route('subCategory.index')->with('success', 'Sub Category has been Added successfully.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $categories = Category::get();
        $subCategory = SubCategory::where('id', $id)->first();
        return view('admin.sub-category.edit', compact(['categories', 'subCategory']));
    }

    public function update(Request $request, $id)
    {
        $id =  decrypt($id);
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
        ]);
        
        $input = $request->except(['_token']);
        
        $category = SubCategory::where('id', $id)->first();

        if ($request->file('image')) {
            deleteImage($category->image);
            $file = $request->file('image');
            $path = 'admin/uploads/category/'.time().$file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $input['image'] = $path;
            }
        }

        SubCategory::where('id',$id)->update($input);

        return redirect()->route('subCategory.index',)->with('success', 'Sub Category has been Updated successfully');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        SubCategory::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Sub Category has been deleted successfully.');
    }
}
