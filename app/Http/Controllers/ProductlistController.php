<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ListItem;
use App\Models\Productlist;
use App\Models\User; // Import User model
use App\Http\Requests\Auth\ProductlistRequestForm;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth; // Import Auth for user management
use App\Models\Category;
use App\Models\Brand;
use App\Models\Theme;
use Illuminate\Support\Facades\Log;
use App\Models\Note;



class ProductlistController extends Controller
{
    

    
    


    
    public function create()
    {
        // Retrieve all products
        $products = Product::with(['brand', 'category'])->get();

        // Group products by category
        $groupedProducts = $products->groupBy('category.name');

        // Retrieve all users (for the user selection dropdown)
        $users = User::where('id', '!=', Auth::id())->get();

        // Retrieve all themes
        $themes = Theme::all();

        $someListId = 1; // Replace with the actual logic to get the list ID
        return view('productlist.create', compact('groupedProducts', 'users', 'themes', 'someListId'));
    }




    public function store(ProductlistRequestForm $request)
{
    $validatedData = $request->validated();

    // Create the list
    $productlist = Productlist::create([
        'name' => $validatedData['name'],
        'theme_id' => $validatedData['theme_id'] ?? null,
    ]);

    // Attach the current user as the owner
    $productlist->users()->attach(Auth::id());

    // Attach products to the list
    if (!empty($validatedData['product_ids'])) {
        $productData = [];
        foreach ($validatedData['product_ids'] as $productId) {
            $quantity = $validatedData['quantities'][$productId] ?? null;
            $productData[$productId] = ['quantity' => $quantity];
        }
        $productlist->products()->attach($productData);
    }

    // Attach invited users to the list
    if (!empty($validatedData['user_ids'])) {
        $productlist->sharedUsers()->attach($validatedData['user_ids']);
    }

    return redirect()->route('lists.index')->with('success', 'List created successfully.');
}


     
    /**
     * Display the specified resource.
     */
    public function show(Productlist $productlist)
{
    $userId = Auth::id();

    // Retrieve the owner using the custom method
    $owner = $productlist->getOwnerAttribute();

    // Determine if the current user is the owner
    $isOwner = $owner && $owner->id === $userId;

    // Check if the user is the owner or a shared user
    if (!$isOwner && !$productlist->sharedUsers->contains($userId)) {
        abort(403, 'Unauthorized access to this list.');
    }

    // Load the necessary relationships
    $productlist->load(['products.brand', 'products.category', 'notes', 'sharedUsers', 'theme']);

    // Get all users except the owner and already shared users
    $users = User::whereNotIn('id', $productlist->sharedUsers->pluck('id'))
                 ->get();

    // Pass the owner to the view
    return view('productlist.show', compact('productlist', 'users', 'isOwner', 'owner'));
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Productlist $productlist)
    {
        $products = Product::with(['brand', 'category'])->get();

        $productlist = $productlist->load(['products.brand', 'products.category']);

        // Group products by category name 
        $groupedProducts = $products->groupBy('category.name');

        // Update the view path to match the directory structure
        return view('productlist.edit', compact('productlist', 'products', 'groupedProducts'));
    }

    
    

    
    public function invite(Request $request, Productlist $productlist)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
    
        // Attach the user to the list
        $productlist->sharedUsers()->attach($validatedData['user_id']);
    
        return redirect()->route('productlist.show', $productlist->id)->with('success', 'User invited successfully.');
    }


    public function destroy($id)
    {
        $list = Productlist::findOrFail($id);
        $list->delete();

        // Redirect to the lists.index route
        return redirect()->route('lists.index')->with('success', 'List deleted successfully.');
    }

    public function update(ProductlistRequestForm $request, Productlist $productlist)
    {
        // Validate the request data
        $validatedData = $request->validated();

        // Check for uniqueness, excluding the current product list
        if (Productlist::where('name', $validatedData['name'])
            ->where('id', '!=', $productlist->id)
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'name' => ['A product list with this name already exists.'],
            ]);
        }

        // Update the ProductList
        $productlist->name = $validatedData['name'];
        $productlist->updated_at = now();
        $productlist->save();

        // Prepare data for attaching products
        $productData = [];
        foreach ($validatedData['product_ids'] as $productId) {
            $quantity = isset($validatedData['quantities'][$productId]) ? $validatedData['quantities'][$productId] : null;
            $productData[$productId] = ['quantity' => $quantity];
        }
        // Attach products with quantities
        $productlist->products()->sync($productData);

        // Retrieve the updated product list with related products, brands, and categories
        $productlist->load(['products.brand', 'products.category']);

        // Redirect with success message
        return redirect()->route('productlist.show', $productlist->id)->with('success', 'Product List updated successfully.');
    }

    public function removeUser(Request $request, Productlist $productlist, User $user)
{
    // Retrieve the owner using the user_id field
    $owner = $productlist->owner;
    $isOwner = $owner && $owner->id === Auth::id();

    if (!$isOwner) {
        abort(403, 'Unauthorized action.');
    }

    Log::info('Attempting to remove user from list', [
        'list_id' => $productlist->id,
        'user_id' => $user->id,
        'current_user_id' => Auth::id()
    ]);

    $productlist->sharedUsers()->detach($user->id);

    return redirect()->route('productlist.show', $productlist->id)->with('success', 'User removed successfully.');
}
}