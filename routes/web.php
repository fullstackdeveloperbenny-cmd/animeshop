<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{product:slug}', [\App\Http\Controllers\ShopController::class, 'show'])->name('shop.show');
Route::get('/over-ons', [\App\Http\Controllers\PageController::class, 'about'])->name('pages.about');
Route::get('/contact', [\App\Http\Controllers\PageController::class, 'contact'])->name('pages.contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->except(['show']);
});

require __DIR__.'/auth.php';
