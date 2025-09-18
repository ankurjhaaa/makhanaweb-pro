<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Livewire\Public\Cart;
use App\Livewire\Public\Checkout;
use App\Livewire\Public\Homepage;

// Include user routes from separate file
require __DIR__ . '/user.php';
use App\Livewire\Public\Login;
use App\Livewire\Public\Register;
use App\Livewire\Public\OrderSuccess;
use App\Livewire\Public\Shop;
use App\Livewire\Public\Recipes;
use App\Livewire\Public\Contactus;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Livewire\Public\Signup;
use Illuminate\Support\Facades\Route;
use App\Enums\Role;
use App\Livewire\User\WishlistComponent;
use App\Livewire\Public\Item;


Route::get('/', Homepage::class)->name("home");
Route::get('/shop', Shop::class)->name("shop");
Route::get('/recipes', Recipes::class)->name("recipes");
Route::get('/contact', Contactus::class)->name("contact");
Route::get('/cart', Cart::class)->name("cart");
Route::get('/item/{slug}', Item::class)->name("item");
Route::middleware('auth')->group(function () {
    Route::get('/checkout', Checkout::class)->name('checkout');
});
// Route::get('/order/success', function () {
//     return view('order-success');
// })->name('order.success');
Route::get('/login', Login::class)->name("login");
Route::get('/register', Register::class)->name("register");

Route::get('/order/success', OrderSuccess::class)->name('order.success');

// Authentication Routes
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::post('/logout', [SocialAuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->controller(AdminController::class)->group(function () {

    Route::get('admin/category', 'adminCategoryPage')->name('adminCategoryPage');

    Route::post('admin/addCategory', 'adminCategory')->name('addAdminCategory');
    Route::delete('admin/deleteCategory/{id}', 'deleteCategory')->name('deleteAdminCategory');
    Route::put('admin/editCategory/{id}', 'editCategory')->name('editAdminCategory');
    Route::get('/admin', function () {
        return redirect()->route('admindashboard');
    });

    Route::get('admin/category', 'adminCategoryPage')->name('adminCategoryPage');
    Route::post('admin/addCategory', 'adminCategory')->name('addAdminCategory');
    Route::delete('admin/deleteCategory/{id}', 'deleteCategory')->name('deleteAdminCategory');
    Route::put('admin/editCategory/{id}', 'editCategory')->name('editAdminCategory');

    Route::get('admin/products', 'allProducts')->name('allProducts');
    Route::post('admin/addProducts', 'addProducts')->name('addProducts');
    Route::delete('admin/deleteProduct/{id}', 'deleteProduct')->name('deleteProduct');
    Route::put('admin/updateProduct/{id}', 'updateProduct')->name('updateProduct');
    Route::get('admin/products', 'searchProducts')->name('searchProducts');

    Route::get('admin/coupons', 'allCoupons')->name('allCouponsPage');
    Route::post('admin/addCoupon', 'addCoupons')->name('addCoupons');
    Route::delete('admin/deleteCoupon/{id}', 'deleteCoupon')->name('deleteCoupon');
    Route::put('admin/updateCoupon/{id}', 'updateCoupon')->name('updateCoupon');

    Route::get('admin/allUsers', 'allUsers')->name('allUsers');
    Route::post('admin/addUser', 'addUser')->name('addUser');
    Route::delete('admin/deleteUser/{id}', 'deleteUser')->name('deleteUser');

    Route::get('admin/allOrders', 'allOrders')->name('allOrders');

    Route::get('admin/dashboard', 'dashboard')->name('admindashboard');

    Route::get('admin/productCombo', 'productCombo')->name('productComboPage');
    Route::post('admin/addProductCombo', 'addProductCombo')->name('addProductCombo');
    Route::delete('admin/deleteCombos/{id}', 'deleteCombos')->name('deleteCombos');

    Route::get('admin/allUsers', 'allUsers')->name('allUsers');

    Route::get('admin/allOrders', 'allOrders')->name('allOrders');

    Route::get('admin/dashboard', 'dashboard')->name('admindashboard');
    Route::get('/admin/orders/{id}', 'viewOrder')->name('admin.viewOrder');
    Route::delete('/admin/orders/{id}', 'deleteOrder')->name('admin.deleteOrder');

    Route::get('/admin/orders/{id}', [AdminController::class, 'viewOrder'])->name('admin.viewOrder');
    Route::put('/orders/{order}/status', [AdminController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('/admin/orders/{id}/delivery-slip', [AdminController::class, 'deliverySlip'])->name('orders.deliverySlip');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admindashboard');


});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', Checkout::class)->name('checkout');
    Route::get('/online-payment/{order}', [PaymentController::class, 'showPaymentPage'])->name('online.payment');
    Route::post('/online-payment/{order}', [PaymentController::class, 'processPayment'])->name('online.payment.process');
    Route::post('/payment-success/{id}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

    Route::get('/payment/online/{id}', [PaymentController::class, 'paymentpage'])->name('payment.online');
});
// Route::get('/online-payment/{order}', [App\Http\Controllers\PaymentController::class, 'showPaymentPage'])
//     ->name('online.payment');
// Route::post('/online-payment/{order}', [App\Http\Controllers\PaymentController::class, 'processPayment'])
//     ->name('online.payment.process');

// Route::post('/online-payment/save', [\App\Http\Controllers\PaymentController::class, 'savePayment']);

// Route::get('/payment-success/{order}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');


// // Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
// Route::get('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
// Route::get('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');