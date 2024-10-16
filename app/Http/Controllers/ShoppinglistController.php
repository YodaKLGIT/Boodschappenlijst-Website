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


class ShoppinglistController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {

        $user = Auth::user();
        
        $shoppinglists = Shoppinglist::accessibleBy($user)
            ->with(['products.brand', 'products.category'])
            ->get();

        $shoppinglists = $this->filter($request, $shoppinglists);
        
        $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');
   
        return view('shoppinglist.index', compact('shoppinglists', 'groupedProducts'));
    }

    public function filter(Request $request, $shoppinglists)
    {
        $sort = $request->input('sort', 'title');

        switch ($sort) {
            case 'last_added':
                return $shoppinglists->sortByDesc('created_at');
            case 'last_updated':
                return $shoppinglists->sortByDesc('updated_at');
            default:
                return $shoppinglists->sortBy('name');
        }
    }


    public function addNote(Request $request, Shoppinglist $shoppinglist)
    {
        $this->authorize('update', $shoppinglist);
        
        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $note = new Note([
            'content' => $validatedData['content'],
            'user_id' => Auth::id(),
        ]);

        $shoppinglist->notes()->save($note);

        return redirect()->route('shoppinglists.show', $shoppinglist)
            ->with('success', 'Note added successfully');
    }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        $products = Product::with('category', 'brand')->get();
        $groupedProducts = $products->groupBy('category.name');

        return view('shoppinglist.create', compact('users', 'groupedProducts'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_ids' => 'array',
            'user_ids.*' => 'exists:users,id',
            'product_ids' => 'array',
            'product_ids.*' => 'exists:products,id',
            'quantities' => 'array',
            'quantities.*' => 'nullable|integer|min:0',
        ]);

        $shoppingList = Shoppinglist::create([
            'name' => $validatedData['name'],
            'user_id' => Auth::id(),
        ]);

        // Attach the current user and selected users to the shopping list
        $userIds = $validatedData['user_ids'] ?? [];
        $userIds[] = Auth::id();
        $shoppingList->users()->attach(array_unique($userIds));

        // Attach products with quantities
        $productData = [];
        foreach ($validatedData['product_ids'] ?? [] as $productId) {
            $quantity = $validatedData['quantities'][$productId] ?? null;
            $productData[$productId] = ['quantity' => $quantity];
        }
        $shoppingList->products()->attach($productData);

        return redirect()->route('shoppinglist.index')->with('success', 'Shopping list created successfully.');
    }

    public function show(Shoppinglist $shoppinglist)
    {
        $this->authorize('view', $shoppinglist);
        $products = $shoppinglist->products()->with(['brand', 'category'])->get();

        return view('shoppinglist.show', compact('shoppinglist', 'products'));
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

        return redirect()->route('shoppinglist.index')->with('success', 'Shopping list deleted successfully.');
    }
}
