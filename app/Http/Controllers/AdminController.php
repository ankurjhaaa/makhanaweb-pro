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
    public function deleteProduct($id)
    {
        $products = Product::findOrFail($id);
        $products->delete();
        return back()->with('success', 'product delete successfully');
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
    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->update($request->only('name', 'category_id', 'price', 'stock', 'description'));

        return back()->with('success', 'Product updated successfully ');
    }
    public function searchProducts(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        }

        $products = $query->with('category')->latest()->paginate(10);
        $categories = Category::all();

        return view('admin.products', compact('products', 'categories'));
    }


}
