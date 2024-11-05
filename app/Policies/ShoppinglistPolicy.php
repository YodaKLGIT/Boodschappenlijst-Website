<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Shoppinglist;

class ShoppinglistPolicy
{
    public function view(User $user, Shoppinglist $shoppinglist)
    {
        return $user->id === $shoppinglist->user_id || $shoppinglist->sharedUsers->contains($user);
    }

    public function create(User $user)
    {
        return true; // Assuming any user can create a shoppinglist
    }

    public function update(User $user, Shoppinglist $shoppinglist)
    {
        return $user->id === $shoppinglist->user_id || $shoppinglist->sharedUsers->contains($user);
    }

    public function delete(User $user, Shoppinglist $shoppinglist)
    {
        return $user->id === $shoppinglist->user_id;
    }

    public function share(User $user, Shoppinglist $shoppinglist)
    {
        return $user->ownedShoppinglists()->where('shoppinglist_id', $shoppinglist->id)->exists() ||
               $user->hasPermissionTo('share-any-shoppinglist');
    }
}
