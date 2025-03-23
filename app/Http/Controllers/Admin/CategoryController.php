<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg',
        ]);

        if ($request->file('image')) {
            $file = $request->file('image');
            $path = 'admin/uploads/category/'.time().$file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $image = $path;
            }
        }

        $category = new Category();
        $category->name = $request->name;
        $category->image = $image;
        $category->type = $request->type;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category has been Added successfully.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $category = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $id =  decrypt($id);
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
        ]);
        
        $input = $request->except(['_token']);
        
        $category = Category::where('id', $id)->first();

        if ($request->file('image')) {
            deleteImage($category->image);
            $file = $request->file('image');
            $path = 'admin/uploads/category/'.time().$file->getClientOriginalName();
            if (uploadImage($path, $file)) {
                $input['image'] = $path;
            }
        }

        Category::where('id',$id)->update($input);

        return redirect()->route('category.index',)->with('success', 'Category has been Updated successfully');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        Category::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Category has been deleted successfully.');
    }
}
