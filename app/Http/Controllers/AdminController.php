<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\product_pricing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use ImageKit\ImageKit;


class AdminController extends Controller
{
     public function dashboard()
    {
       $orders = Order::with('user')->latest()->get();
        $users  = User::latest()->take(2)->get();

        return view('admin.dashboard', compact('orders', 'users'));
    }
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
        $imageKit = new ImageKit(
            config('services.imagekit.public_key'),
            config('services.imagekit.private_key'),
            config('services.imagekit.url_endpoint')
        );
        if ($products->image) {
            $imageKit->deleteFile($products->image);
        }
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
            'image' => 'required|image',
            'mrp' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
        ]);

        $imageKit = new ImageKit(
            config('services.imagekit.public_key'),
            config('services.imagekit.private_key'),
            config('services.imagekit.url_endpoint')
        );

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileContent = file_get_contents($file->getRealPath());

            $uploadFile = $imageKit->upload([
                'file' => base64_encode($fileContent),
                'fileName' => time() . '_' . $file->getClientOriginalName(),
            ]);

            if (isset($uploadFile->result) && isset($uploadFile->result->url)) {
                $imageFileId = $uploadFile->result->fileId;
                $imagelink = $uploadFile->result->url;
            }
        }

        Product::create(attributes: [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imageFileId,
            'imagelink' => $imagelink,
            'mrp' => $request->mrp,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'slug' => null,
        ]);

        return back()->with('success', 'Product added successfully');
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
            'mrp' => 'required|numeric',
            'quantity' => 'required|numeric',
            'unit' => 'required|string|max:50',
        ]);

        $imageKit = new ImageKit(
            config('services.imagekit.public_key'),
            config('services.imagekit.private_key'),
            config('services.imagekit.url_endpoint')
        );

        $product = Product::findOrFail($id);

        $imageFileId = $product->image;       // by default old image
        $imagelink = $product->imagelink;   // by default old image link

        // Agar nayi image upload ho rahi hai
        if ($request->hasFile('image')) {
            // Purani image delete kar do
            if ($product->image) {
                try {
                    $imageKit->deleteFile($product->image);
                } catch (\Exception $e) {
                    \Log::error('Image delete failed: ' . $e->getMessage());
                }
            }

            // Nayi image upload
            $file = $request->file('image');
            $fileContent = file_get_contents($file->getRealPath());

            $uploadFile = $imageKit->upload([
                'file' => base64_encode($fileContent),
                'fileName' => time() . '_' . $file->getClientOriginalName(),
            ]);

            if (isset($uploadFile->result) && isset($uploadFile->result->url)) {
                $imageFileId = $uploadFile->result->fileId;
                $imagelink = $uploadFile->result->url;
            }
        }

        // Update product
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'mrp' => $request->mrp,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'image' => $imageFileId,
            'imagelink' => $imagelink,
        ]);

        return back()->with('success', 'Product updated successfully');
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

    public function viewOrder($id)
    {
        $order = Order::with(['orderItems.product', 'shippingAddress', 'billingAddress'])
            ->findOrFail($id);

        return view('admin.viewOrder', compact('order'));
    }
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated successfully!');
    }


    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return back()->with('success', 'Order deleted successfully');
    }

    public function deliverySlip($id)
    {

        $order = Order::with(['orderItems.product', 'shippingAddress', 'billingAddress'])
            ->findOrFail($id);


        return view('admin.delivery-slip', compact('order'));
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'user deleted successfully');
    }
    public function addUser(Request $request)
    {
        $addUser = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required',
        ]);
        User::create([
            'name' => $request->first_name . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        return back()->with('success', 'userr added successfully');


    }
    public function productCombo()
    {
        $products = Product::all();
        $combos = Product_pricing::all();
        return view('admin.productCombo', compact('products', 'combos'));
    }
    public function addProductCombo(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'product_id' => 'nullable|numeric',
            'combo_products' => 'nullable',
        ]);
        if (!$request->product_id && (!$request->combo_products || count($request->combo_products) == 0)) {
            return back()->with('error', 'Please select either a Single Product or at least one Combo Product.');
        }

        Product_pricing::create([
            'product_id' => $request->product_id ?? null,
            'combo_products' => $request->combo_products ? json_encode($request->combo_products) : null,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Combo Pricing saved successfully!');
    }
    public function deleteCombos($id)
    {
        $combos = Product_pricing::findOrFail($id);
        $combos->delete();
        return back()->with('success', 'combos delete successfuly');
    }


}
