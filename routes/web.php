<?php

use App\Http\Controllers\AdminController;
use App\Livewire\Public\Cart;
use App\Livewire\Public\Checkout;
use App\Livewire\Public\Homepage;
use App\Livewire\Public\Login;
use App\Livewire\Public\OrderSuccess;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', Homepage::class)->name("home");
Route::get('/cart', Cart::class)->name("cart");
Route::get('/checkout', Checkout::class)->name("checkout");
Route::get('/login', Login::class)->name("login");

Route::get('/order/success', OrderSuccess::class)->name('order.success');

// Authentication Routes
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::post('/logout', [SocialAuthController::class, 'logout'])->name('logout');

Route::get('/admin', function () {
    return view('admin/layout');
});

Route::get('admin/category', [AdminController::class, 'adminCategoryPage'])->name('adminCategoryPage');
Route::post('admin/addCategory', [AdminController::class, 'adminCategory'])->name('addAdminCategory');
Route::delete('admin/deleteCategory/{id}', [AdminController::class, 'deleteCategory'])->name('deleteCategory');
