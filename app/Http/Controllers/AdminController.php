<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminCategoryPage()
    {
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }
    public function deleteCategory($id)
    {
        $findCategories = Category::findOrFail($id);
        $findCategories->delete();
        return back()->with('success', 'category deleted succesfully');
    }
    public function editCategory($id, Request $request)
    {
        $findCategories = Category::findOrFail($id);
        $findCategories->name = $request->name;
        $findCategories->description = $request->description;
        $findCategories->parent_id = $request->parent_id;
        $findCategories->save();
        return back()->with('success', 'category edit succesfully');
    }
    public function adminCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        $addCategory = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'slug' => null,
        ]);

        return back()->with('seccess', 'category added successfully');
    }


    public function allproducts()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('admin.products', compact('products', 'categories'));
    }
    public function addProducts(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
        $addCategory = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'slug' => null,
        ]);

        return back()->with('success', 'add successfully');
    }

}
