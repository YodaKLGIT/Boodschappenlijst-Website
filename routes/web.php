<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\ProductlistController;
use Illuminate\Support\Facades\Route;

// home
Route::get('/', [HomeController::class, 'index'])->name('home');

// products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/filter-by-brand', [ProductController::class, 'filterByBrand'])->name('products.filterByBrand');


Route::middleware(['auth'])->group(function () {
    Route::get('/lists', [ListController::class, 'index'])->name('lists.index');
    
    // Custom route for removing a product from a list
    Route::delete('/lists/{list}/products/{product}', [ListController::class, 'removeProductFromList'])
        ->name('lists.products.remove');

    Route::resource('/productlist', ProductlistController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
