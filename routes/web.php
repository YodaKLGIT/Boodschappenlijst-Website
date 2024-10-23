<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ShoppinglistController;
use App\Http\Controllers\UserShoppingListController;
use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication required routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Shopping List routes
    Route::resource('shoppinglist', ShoppinglistController::class);
    Route::get('/shoppinglist/{shoppinglist}/products', [ShoppinglistController::class, 'viewProducts'])->name('shoppinglist.view_products');

    // Note routes
    Route::post('/shoppinglist/{shoppinglist}/add-note', [NoteController::class, 'store'])->name('shoppinglist.add_note');

    // User Shopping List Management routes
    Route::get('/users/{userId}/shopping-lists', [UserShoppingListController::class, 'index'])->name('users.shoppinglists.index');
    Route::post('/users/{userId}/attach-list', [UserShoppingListController::class, 'attachList'])->name('users.shoppinglists.attach');
    Route::post('/users/{userId}/detach-list/{listId}', [UserShoppingListController::class, 'detachList'])->name('users.shoppinglists.detach');
    Route::get('/shopping-lists/{listId}/users', [UserShoppingListController::class, 'listUsers'])->name('lists.users.index');
    Route::get('/manage-user-lists', [UserShoppingListController::class, 'manageUserLists'])->name('user.shopping.lists.manage');
    Route::post('/update-user-lists', [UserShoppingListController::class, 'updateUserLists'])->name('user.shopping.lists.update');
    Route::post('/shopping-lists/{listId}/detach-user', [UserShoppingListController::class, 'detachUser'])->name('lists.users.detach');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Invitation routes
    Route::post('/shoppinglist/{shoppinglist}/invite', [InvitationController::class, 'store'])->name('invitation.store');
    Route::post('/invitation/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitation.accept');
    Route::post('/invitation/{invitation}/decline', [InvitationController::class, 'decline'])->name('invitation.decline');

    Route::post('/shoppinglists/{shoppinglist}/notes', [NoteController::class, 'store'])->name('notes.store');

    Route::post('/shoppinglists/{shoppinglist}/invite', [ShoppinglistController::class, 'invite'])->name('shoppinglist.invite');
    
    Route::resource('shoppinglist', ShoppinglistController::class)->middleware(['auth']);

    Route::get('/mail', [InvitationController::class, 'mail']);

    Route::delete('/shoppinglists/{shoppinglist}/users/{user}', [ShoppinglistController::class, 'removeUser'])->name('shoppinglist.removeUser');
});

// Include authentication routes
require __DIR__ . '/auth.php';

