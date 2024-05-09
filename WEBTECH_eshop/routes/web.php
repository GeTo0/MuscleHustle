<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::get('/', function () {
    return view('welcome');
})->name('homepage');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/catalog', function () {
    return view('catalog');
})->name('catalog');

Route::get('/shopping_cart', function () {
    // Fetch cart items from the database
    $cartItems = App\Models\Cart::all(); // Adjust namespace and model name as per your project structure

    // Pass cart items to the view
    return view('shopping_cart', ['cartItems' => $cartItems]);
})->name('shopping_cart');

Route::post('/add-to-cart/{productId}', [CartController::class, 'addToCart'])->name('add_to_cart');

Route::get('/edit_product', function () {
    return view('edit_product');
})->name('edit_product');

Route::get('/admin_main', function () {
    return view('admin_main');
})->name('admin_page');

 Route::get('/product', function () {
     return view('product');
 })->name('product');

 Route::get('/product/{productName}', [ProductController::class, 'show'])->name('product.show');


Route::get('/catalog/products', [ProductController::class, 'getAllProducts']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
