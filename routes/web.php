<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\ProductlistController;
use App\Http\Controllers\ShoppinglistController;
use App\Http\Controllers\UserProductListController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ListServiceController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('productlist', ProductlistController::class);




// products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/filter-by-brand', [ProductController::class, 'filterByBrand'])->name('products.filterByBrand');

Route::middleware(['auth'])->group(function () {
    Route::post('/productlist/add', [ProductlistController::class, 'add'])->name('productlist.add');
});
// Shopping List routes
//Route::resource('shoppinglist', ShoppinglistController::class);
    //Route::get('/shoppinglist/{shoppinglist}/products', [ShoppinglistController::class, 'viewProducts'])->name('shoppinglist.view_products');
    
Route::middleware(['auth'])->group(function () {
    Route::get('/lists', [ListController::class, 'index'])->name('lists.index');

    
    Route::resource('/productlists', ProductlistController::class);
    Route::middleware(['auth'])->group(function () {
        Route::post('/lists/{list}/notes', [NoteController::class, 'store'])->name('list.notes.store');
        // Other routes that require authentication
    });
    
    // Custom route for removing a product from a list
    Route::delete('/lists/{list}/products/{product}', [ListServiceController::class, 'removeProductFromList'])
        ->name('lists.products.remove');
        
    Route::get('/lists/favorites', [ListServiceController::class, 'getFavoriteLists'])->name('lists.favorites');
    Route::post('/lists/{list}/favorite', [ListServiceController::class, 'toggleFavorite'])->name('lists.toggleFavorite');
    
    Route::post('/lists/{list}/updateName', [ListServiceController::class, 'updateName'])->name('lists.updateName');

    Route::post('/lists/{list}/products/{product}/mark-seen', [ListServiceController::class, 'markProductAsSeen'])
    ->name('product.markAsSeen');

    Route::get('/lists', [ListServiceController::class, 'listFilter'])->name('lists.filter');



        Route::delete('/lists/{list}', [ListController::class, 'destroy'])->name('lists.destroy');

        Route::post('/productlist/{productlist}/invite', [ProductlistController::class, 'invite'])->name('productlist.invite');

        Route::delete('/productlist/{productlist}/remove-user/{user}', [ProductlistController::class, 'removeUser'])->name('productlist.removeUser');

    // Custom route for viewing favorite lists
  
    Route::patch('/lists/{listItem}/products/{product}/newproduct', [ProductListController::class, 'Newproduct'])
    ->name('lists.products.newproduct');

    
    Route::resource('/productlist', ProductlistController::class);

   

    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Invitation routes
    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::post('/invitations/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitations/{invitation}/decline', [InvitationController::class, 'decline'])->name('invitations.decline');


    Route::post('/productlist/{productlist}/notes', [ProductlistController::class, 'storeNote'])->name('notes.store');
    


    Route::get('/productlist/{productlist}', [ProductlistController::class, 'show'])->name('productlist.show');

    Route::post('/lists/{listItem}/notes', [NoteController::class, 'store'])->name('notes.store');

    Route::get('/productlist/{productlist}/edit', [ProductlistController::class, 'edit'])->name('productlist.edit');

    Route::delete('/productlist/{id}', [ProductListController::class, 'destroy'])->name('productlist.destroy');

    Route::delete('/productlist/{productlist}/product/{product}', [ProductlistController::class, 'removeProduct'])
        ->name('productlist.removeProduct');

});

// Include authentication routes
require __DIR__ . '/auth.php';


