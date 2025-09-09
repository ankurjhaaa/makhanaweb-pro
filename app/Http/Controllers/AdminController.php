<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
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


    public function allProducts()
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,wepg|max:10000',

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

    public function allCoupons()
    {
        $coupons = Coupon::all();
        return view('admin.Coupons', compact('coupons'));
    }
    public function deleteCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return back()->with('success', 'cou[on deteted sucesfully');
    }
    public function updateCoupon($id, Request $request)
    {
        $coupon = Coupon::findOrFail($id);
        $request->validate([
            'code' => 'required|string|max:50',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'usage_limit' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);
        $coupon->update([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount,
            'max_discount_amount' => $request->max_discount_amount,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'usage_limit' => $request->usage_limit,
            'status' => $request->status,
        ]);

        return back()->with('success', 'coupon updated sucesfully');
    }
    public function addCoupons(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        Coupon::create($validated);

        return redirect()->back()->with('success', 'Coupon added successfully!');
    }


    public function allUsers()
    {
        $allUsers = User::all();
        return view('admin.users', compact('allUsers'));
    }
    public function allOrders()
    {
        $allOrders = Order::all();
        return view('admin.orders', compact('allOrders'));
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
