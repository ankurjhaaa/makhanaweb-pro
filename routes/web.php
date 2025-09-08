<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    // Admin Dashboard
    Route::get('/', function () {
        return view('admin.layout'); // resources/views/admin/layout.blade.php
    })->name('admin.dashboard');

    // Admin Category Page
    Route::get('/category', function () {
        return view('admin.category'); // resources/views/admin/categories.blade.php
    })->name('admin.category');

    // Admin Products Page
    Route::get('/products', function () {
        return view('admin.products'); // resources/views/admin/products.blade.php
    })->name('admin.products');
});

// Public Route (Home Page)
Route::get('/', function () {
    return view('welcome');
})->name('home');