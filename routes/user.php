<?php

use App\Livewire\User\Dashboard;
use App\Livewire\User\Myorder;
use App\Livewire\User\OrderDetail;
use App\Livewire\User\Profile;
use App\Livewire\User\Addresses;
use App\Livewire\User\Wishlist;
use App\Livewire\User\WishlistComponent;
use Illuminate\Support\Facades\Route;

// User routes - all protected by auth middleware
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('user.dashboard');
    Route::get('/profile', Profile::class)->name('user.profile');
    Route::get('/orders', Myorder::class)->name('user.orders');
    Route::get('/addresses', Addresses::class)->name('user.addresses');
    Route::get('/wishlist', WishlistComponent::class)->name('user.wishlist');
    Route::get('/orderdetail/{order_number}',OrderDetail::class)->name('user.orderdetail');
});