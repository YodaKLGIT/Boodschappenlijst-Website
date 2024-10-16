<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ShoppingList;
use Illuminate\Http\Request;

class UserShoppingListController extends Controller
{
    public function updateUserLists(Request $request)
{
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'shopping_lists' => 'required|array',
        'shopping_lists.*' => 'exists:lists,id', // Make sure the IDs are valid
    ]);

    // Attach or sync the lists with the user
    $user = User::find($validatedData['user_id']);
    $user->shoppingLists()->sync($validatedData['shopping_lists']);

    return redirect()->route('user.shopping.lists.manage')->with('success', 'User shopping lists updated successfully!');
}




    // Show all lists for a specific user
    public function index($userId)
    {
        $user = User::findOrFail($userId);
        $shoppingLists = $user->shoppingLists;

        return view('users.shoppinglists.index', compact('user', 'shoppingLists'));
    }


    
    // Attach a shopping list to a user
    public function attachList(Request $request, $userId)
    {
        $request->validate([
            'list_id' => 'required|exists:lists,id',
        ]);

        $user = User::findOrFail($userId);
        $user->shoppingLists()->attach($request->list_id);

        return redirect()->route('users.shoppinglists.index', $userId)
                         ->with('success', 'List attached to user successfully.');
    }

    // Detach a shopping list from a user
    public function detachList(Request $request, $userId, $listId)
    {
        $user = User::findOrFail($userId);
        $user->shoppingLists()->detach($listId);

        return redirect()->route('users.shoppinglists.index', $userId)
                         ->with('success', 'List detached from user successfully.');
    }

    public function detachUser(Request $request, $listId)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $shoppingList = ShoppingList::findOrFail($listId);
    $shoppingList->users()->detach($request->user_id);

    return redirect()->route('lists.users.index', $listId)
                     ->with('success', 'User removed from shopping list successfully.');
}

    

    // Show all users assigned to a shopping list
    public function listUsers($listId)
{
    $shoppingList = ShoppingList::findOrFail($listId);
    $users = $shoppingList->users;

    return view('shoppinglist.userlist', compact('shoppingList', 'users'));
}




    public function manageUserLists()
{
    $users = User::all(); // Fetch all users
    $shoppingLists = ShoppingList::all(); // Fetch all shopping lists

    return view('shoppinglist.manage_user_lists', compact('users', 'shoppingLists'));
}

}
