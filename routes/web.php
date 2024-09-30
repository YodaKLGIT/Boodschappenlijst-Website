<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShoppinglistController;
use Illuminate\Support\Facades\Route;

// home
Route::get('/', [HomeController::class, 'index'])->name('home');
<<< HEAD
Route::get('shoppinglists', [ShoppinglistController::class, 'index'])->name('shoppinglists.index');
=======
Route::resource('/shoppinglist', ShoppinglistController::class);
>>>>>>> 277d59529578d10e221c562b01abe926e3c0b638

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
