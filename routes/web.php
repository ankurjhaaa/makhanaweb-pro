<?php

use App\Http\Controllers\AdminController;
use App\Livewire\Public\Cart;
use App\Livewire\Public\Checkout;
use App\Livewire\Public\Homepage;
use App\Livewire\Public\Login;
use App\Livewire\Public\Register;
use App\Livewire\Public\OrderSuccess;
use App\Livewire\Public\Shop;
use App\Livewire\Public\Recipes;
use App\Livewire\Public\Contactus;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Livewire\Public\Signup;
use Illuminate\Support\Facades\Route;


Route::get('/', Homepage::class)->name("home");
Route::get('/shop', Shop::class)->name("shop");
Route::get('/recipes', Recipes::class)->name("recipes");
Route::get('/contact', Contactus::class)->name("contact");
Route::get('/cart', Cart::class)->name("cart");
Route::middleware('auth')->group(function () {
    Route::get('/checkout', Checkout::class)->name('checkout');
});
Route::get('/login', Login::class)->name("login");
Route::get('/register', Register::class)->name("register");

Route::get('/order/success', OrderSuccess::class)->name('order.success');

// Authentication Routes
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::post('/logout', [SocialAuthController::class, 'logout'])->name('logout');

Route::get('/admin', function () {
    return redirect()->route('admindashboard');
});

Route::get('admin/category', [AdminController::class, 'adminCategoryPage'])->name('adminCategoryPage');
Route::post('admin/addCategory', [AdminController::class, 'adminCategory'])->name('addAdminCategory');
Route::delete('admin/deleteCategory/{id}', [AdminController::class, 'deleteCategory'])->name('deleteAdminCategory');
Route::put('admin/editCategory/{id}', [AdminController::class, 'editCategory'])->name('editAdminCategory');

Route::get('admin/products', [AdminController::class, 'allProducts'])->name('allProducts');
Route::post('admin/addProducts', [AdminController::class, 'addProducts'])->name('addProducts');
Route::delete('admin/deleteProduct/{id}', [AdminController::class, 'deleteProduct'])->name('deleteProduct');
Route::put('admin/updateProduct/{id}', [AdminController::class, 'updateProduct'])->name('updateProduct');
Route::get('admin/products', [AdminController::class, 'searchProducts'])->name('searchProducts');

Route::get('admin/coupons', [AdminController::class, 'allCoupons'])->name('allCouponsPage');
Route::post('admin/addCoupon', [AdminController::class, 'addCoupons'])->name('addCoupons');
Route::delete('admin/deleteCoupon/{id}', [AdminController::class, 'deleteCoupon'])->name('deleteCoupon');
Route::put('admin/updateCoupon/{id}', [AdminController::class, 'updateCoupon'])->name('updateCoupon');

Route::get('admin/allUsers', [AdminController::class, 'allUsers'])->name('allUsers');
Route::post('admin/addUser', [AdminController::class, 'addUser'])->name('addUser');
Route::delete('admin/deleteUser/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');

Route::get('admin/allOrders', [AdminController::class, 'allOrders'])->name('allOrders');

Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admindashboard');

Route::get('admin/productCombo', [AdminController::class, 'productCombo'])->name('productComboPage');
Route::post('admin/addProductCombo', [AdminController::class, 'addProductCombo'])->name('addProductCombo');
Route::delete('admin/deleteCombos/{id}', [AdminController::class, 'deleteCombos'])->name('deleteCombos');

Route::get('admin/allUsers', [AdminController::class, 'allUsers'])->name('allUsers');

Route::get('admin/allOrders', [AdminController::class, 'allOrders'])->name('allOrders');

Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admindashboard');
Route::get('/admin/orders/{id}', [AdminController::class, 'viewOrder'])->name('admin.viewOrder');
Route::delete('/admin/orders/{id}', [AdminController::class, 'deleteOrder'])->name('admin.deleteOrder');




// // Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
// Route::get('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
// Route::get('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');