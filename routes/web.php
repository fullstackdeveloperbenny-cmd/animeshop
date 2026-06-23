<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

// Shop Routes
Route::controller(ShopController::class)->name('shop.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/product/{product:slug}', 'show')->name('show');
});

// Pagina Routes
Route::controller(PageController::class)->name('pages.')->group(function () {
    Route::get('/over-ons', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'sendContactMessage')->name('contact.send');
    Route::get('/algemene-voorwaarden', 'terms')->name('terms');
    Route::get('/privacybeleid', 'privacy')->name('privacy');
    Route::get('/retourbeleid', 'returns')->name('returns');
});

// Winkelwagen Routes
Route::prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/add/{product}', 'add')->name('add');
    Route::patch('/update/{itemKey}', 'update')->name('update');
    Route::delete('/remove/{itemKey}', 'remove')->name('remove');
});

// Checkout Routes
Route::prefix('checkout')->name('checkout.')->controller(CheckoutController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/process', 'process')->name('process');
    Route::get('/success/{order}', 'success')->name('success');
    Route::get('/cancel/{order}', 'cancel')->name('cancel');
});

// Default Dashboard
Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // Klanten Routes
    Route::controller(CustomerController::class)->name('customer.')->group(function () {
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
    Route::post('categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore')->withTrashed();
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::get('products/trash', [ProductController::class, 'trash'])->name('products.trash');
    Route::post('products/{product}/restore', [ProductController::class, 'restore'])->name('products.restore')->withTrashed();
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
});

require __DIR__.'/auth.php';
