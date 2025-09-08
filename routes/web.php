<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/admin
', function () {
    return view('admin/layout');
});

Route::get('admin/category', [AdminController::class, 'adminCategoryPage'])->name('adminCategoryPage');
Route::post('admin/addCategory', [AdminController::class, 'adminCategory'])->name('addAdminCategory');
Route::delete('admin/deleteCategory/{id}', [AdminController::class, 'deleteCategory'])->name('deleteCategory');
