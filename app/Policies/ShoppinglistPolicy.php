<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Shoppinglist;

class ShoppinglistPolicy
{
    public function view(User $user, Shoppinglist $shoppinglist)
    {
        return $user->shoppinglists()->where('shoppinglist_id', $shoppinglist->id)->exists() ||
               $user->hasPermissionTo('view-any-shoppinglist');
    }

    public function create(User $user)
    {
        return true; // Assuming any user can create a shoppinglist
    }

    public function update(User $user, Shoppinglist $shoppinglist)
    {
        return $user->shoppinglists()->where('shoppinglist_id', $shoppinglist->id)
                    ->wherePivotIn('permissions', ['edit', 'all'])
                    ->exists() ||
               $user->hasPermissionTo('edit-any-shoppinglist');
    }

    public function delete(User $user, Shoppinglist $shoppinglist)
    {
        return $user->ownedShoppinglists()->where('shoppinglist_id', $shoppinglist->id)->exists() ||
               $user->hasPermissionTo('delete-any-shoppinglist');
    }

    public function share(User $user, Shoppinglist $shoppinglist)
    {
        return $user->ownedShoppinglists()->where('shoppinglist_id', $shoppinglist->id)->exists() ||
               $user->hasPermissionTo('share-any-shoppinglist');
    }
}