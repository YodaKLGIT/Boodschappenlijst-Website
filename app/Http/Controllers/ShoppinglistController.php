<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Shoppinglist;
use App\Http\Requests\Auth\ShoppinglistRequest;
use Illuminate\Support\Facades\Gate;
use App\Policies\ShoppinglistPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShoppingListInvitation;


class ShoppinglistController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = Auth::user();
        
        $shoppinglists = Shoppinglist::accessibleBy($user)
            ->with(['products.brand', 'products.category', 'user', 'sharedUsers'])
            ->get();

        $sort = $request->input('sort', 'name');
        $shoppinglists = $this->filterShoppinglists($shoppinglists, $sort);
        
        $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');

        return view('shoppinglist.index', compact('shoppinglists', 'groupedProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retrieve all products
        $products = Product::with(['brand', 'category'])->get();

        // Group products by category
        $groupedProducts = $products->groupBy('category.name');

        // Retrieve all users (for the user selection dropdown)
        $users = User::where('id', '!=', Auth::id())->get();

        // Return the view to create a new shopping list
        return view('shoppinglist.create', compact('groupedProducts', 'users'));
    }

    

    /**
     * Store a newly created resource in storage.
     */

     public function store(ShoppinglistRequest $request)
    {
        $validatedData = $request->validated();

        $shoppinglist = Shoppinglist::create([
            'name' => $validatedData['name'],
            'user_id' => Auth::id(),
        ]);

        // Attach products if any
        if (!empty($validatedData['product_ids'])) {
            $productData = [];
            foreach ($validatedData['product_ids'] as $index => $productId) {
                $quantity = $validatedData['quantities'][$productId] ?? 1;
                if ($quantity > 0) {
                    $productData[$productId] = ['quantity' => $quantity];
                }
            }
            if (!empty($productData)) {
                $shoppinglist->products()->attach($productData);
            }
        }

        // Attach shared users if any
        if (!empty($validatedData['user_ids'])) {
            $shoppinglist->sharedUsers()->attach($validatedData['user_ids']);
        }

        return redirect()->route('shoppinglist.index')->with('success', 'Shopping list created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Shoppinglist $shoppinglist)
{
    $this->authorize('view', $shoppinglist);

    $shoppinglist->load(['products.brand', 'products.category', 'user', 'sharedUsers', 'notes.user']);

    return view('shoppinglist.shoppinglist', compact('shoppinglist'));
}

    public function viewProducts(Shoppinglist $shoppinglist)
    {
        $this->authorize('view', $shoppinglist);
        $shoppinglist->load(['products.brand', 'products.category']);
    
        return view('shoppinglist.shoppinglist', compact('shoppinglist'));
    }

    public function edit(Shoppinglist $shoppinglist)
    {
        $this->authorize('update', $shoppinglist);
        $products = Product::with(['brand', 'category'])->get(); 
        $shoppinglist = $shoppinglist->load(['products.brand', 'products.category']);
        $groupedProducts = $products->groupBy('category.name');

        return view('shoppinglist.edit', compact('shoppinglist', 'products', 'groupedProducts'));
    }

    public function update(ShoppinglistRequest $request, Shoppinglist $shoppinglist)
    {
        $this->authorize('update', $shoppinglist);
        $validatedData = $request->validated();

        $shoppinglist->update([
            'name' => $validatedData['name'],
        ]);

        $productData = [];
        foreach ($validatedData['product_ids'] ?? [] as $productId) {
            $quantity = $validatedData['quantities'][$productId] ?? null;
            $productData[$productId] = ['quantity' => $quantity];
        }
        $shoppinglist->products()->sync($productData);

        $userIds = $validatedData['user_ids'] ?? [];
        $userIds[] = Auth::id();
        $shoppinglist->users()->sync(array_unique($userIds));

        $shoppinglist->load(['products.brand', 'products.category']);

        return redirect()->route('shoppinglist.index')->with('success', 'Shopping list updated successfully.');
    }

    public function destroy(Shoppinglist $shoppinglist)
    {
        $this->authorize('delete', $shoppinglist);
        $shoppinglist->products()->detach();
        $shoppinglist->users()->detach();
        $shoppinglist->delete();

       return redirect()->route('shoppinglist.index');
    }

    /**
 * Attach a user to the specified shopping list.
 */
public function attachUserToList(Request $request, $listId)
{
    // Validate the user ID
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id', // Check if the user exists
    ]);

    // Find the shopping list
    $shoppinglist = Shoppinglist::findOrFail($listId);

    // Attach the user to the shopping list
    $shoppinglist->users()->attach($validatedData['user_id']);

    return redirect()->route('shoppinglist.show', $listId)->with('success', 'User attached to the list successfully.');
}

/**
 * Detach a user from the specified shopping list.
 */
public function detachUserFromList(Request $request, $listId)
{
    // Validate the user ID
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    // Find the shopping list
    $shoppinglist = Shoppinglist::findOrFail($listId);

    // Detach the user from the shopping list
    $shoppinglist->users()->detach($validatedData['user_id']);

    return redirect()->route('shoppinglist.show', $listId)->with('success', 'User detached from the list successfully.');
}

private function filterShoppinglists($shoppinglists, $sort)
{
    switch ($sort) {
        case 'last_added':
            return $shoppinglists->sortByDesc('created_at');
        case 'last_updated':
            return $shoppinglists->sortByDesc('updated_at');
        default:
            return $shoppinglists->sortBy('name');
    }
}
public function invite(Request $request, Shoppinglist $shoppinglist)
{
    if (Auth::id() !== $shoppinglist->user_id) {
        return redirect()->route('shoppinglist.show', $shoppinglist)
                         ->with('error', 'Only the owner can invite users to this list.');
    }

    $request->validate([
        'email' => 'required|email',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user) {
        $shoppinglist->sharedUsers()->syncWithoutDetaching([$user->id]);
        $message = 'User has been added to the shopping list.';
    } else {
        Mail::to($request->email)->send(new ShoppingListInvitation($shoppinglist));
        $message = 'An invitation has been sent to the email address.';
    }

    return redirect()->route('shoppinglist.show', $shoppinglist)->with('success', $message);
}

public function removeUser(Shoppinglist $shoppinglist, User $user)
{
    if (Auth::id() !== $shoppinglist->user_id) {
        return redirect()->route('shoppinglist.show', $shoppinglist)
                         ->with('error', 'You do not have permission to remove users from this list.');
    }

    $shoppinglist->sharedUsers()->detach($user->id);

    return redirect()->route('shoppinglist.show', $shoppinglist)
                     ->with('success', 'User removed from the shopping list.');
}

}