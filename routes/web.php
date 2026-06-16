<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Shop Routes
Route::controller(\App\Http\Controllers\ShopController::class)->name('shop.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/product/{product:slug}', 'show')->name('show');
});

// Pagina Routes
Route::controller(\App\Http\Controllers\PageController::class)->name('pages.')->group(function () {
    Route::get('/over-ons', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'sendContactMessage')->name('contact.send');
});

// Winkelwagen Routes
Route::prefix('cart')->name('cart.')->controller(\App\Http\Controllers\CartController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/add/{product}', 'add')->name('add');
    Route::patch('/update/{itemKey}', 'update')->name('update');
    Route::delete('/remove/{itemKey}', 'remove')->name('remove');
});

// Checkout Routes
Route::prefix('checkout')->name('checkout.')->controller(\App\Http\Controllers\CheckoutController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/process', 'process')->name('process');
    Route::get('/success/{order}', 'success')->name('success');
    Route::get('/cancel/{order}', 'cancel')->name('cancel');
});

// Default Dashboard
Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // Klanten Routes
    Route::controller(\App\Http\Controllers\CustomerController::class)->name('customer.')->group(function () {
        Route::get('/mijn-profiel', 'profile')->name('profile');
        Route::get('/mijn-bestellingen/{order}', 'order')->name('order');
    });

    // Profile (Breeze) Routes
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->except(['show']);
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);
});

require __DIR__.'/auth.php';
