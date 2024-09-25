<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Product;

use App\Models\Shoppinglist;

class ShoppinglistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $shoppinglists = Shoppinglist::with(['products.brand', 'products.category'])->get();
        return view('shoppinglist.index', compact('shoppinglists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($name)
    {
       // Retrieve all products from the Product model
       $shoppinglist = new Shoppinglist();
       $shoppinglist->name = $name;
       $shoppinglist->save();

       $products = Product::all();
       foreach($products as $product) {
           $shoppinglist->products()->attach($product->id);

         // Retrieve the ShoppingList with related products, brands, and categories
          $shoppinglistWithDetails = Shoppinglist::with(['products.brand', 'products.category'])->find($shoppinglist->id);

         // $shoppinglistWithDetails now contains the ShoppingList with related products, brands, and categories

       }
        return view('index', compact('shoppinglistWithDetails'));
        /* */
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          // Validate the request data
          $validatedData = $request->validate([
              'name' => 'required|string|max:255',
              'product_ids' => 'nullable|string|max:255',
              'product_ids.*' => 'exists:products,id',
              'quantities' => 'nullable|array',
              'quantities.*' => 'integer|min:1',
              'list_id' => 'nullable|exists:product_lists,id',
          ]);

          // Create a new ProductList
          $shoppinglist = Shoppinglist::create([
              'name' => $validatedData['name'],
          ]);

          // Prepare data for attaching products
          $productData = [];
            foreach ($validatedData['product_ids'] as $index => $productId) {
              $productData[$productId] = ['quantity' => $validatedData['quantities'][$index] ?? 1];

          // Attach products with quantities
          $shoppinglist->products()->attach($productData);

           // Redirect with success message
          return redirect()->route('productlist.index')->with('success', 'Product List created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shoppinglist $shoppinglist)
    {
        $products = $shoppinglist->products;

        return view('index', compact('shoppinglist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shoppinglist $shoppinglist)
    {
          // Step 1: You already have the shopping list injected, no need to find it again

         // Step 2: Retrieve all products to display in the view (for selection or updating)
        $products = $shoppinglist->products;

        // Step 3: Retrieve the existing related products, brands, and categories
       $shoppinglistWithDetails = $shoppinglist->load(['products.brand', 'products.category']);

       // Step 4: Pass the data to the edit view (including the shopping list and available products)
       return view('edit', compact('shoppinglistWithDetails', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shoppinglist $shoppinglist)
    {
          // Validate the request data
          $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'product_ids' => 'nullable|string|max:255',
            'product_ids.*' => 'exists:products,id',
            'quantities' => 'nullable|array',
            'quantities.*' => 'integer|min:1',
            'list_id' => 'nullable|exists:product_lists,id',
        ]);

        // Create a new ProductList
        $shoppinglist->name =  $validatedData['name'];
        $shoppinglist->save();

        // Prepare data for attaching products
        $productData = [];
          foreach ($validatedData['product_ids'] as $index => $productId) {
            $productData[$productId] = ['quantity' => $validatedData['quantities'][$index] ?? 1];

        // Attach products with quantities
        $shoppinglist->products()->sync($productData);

         // Step 3: Retrieve the updated shopping list with related products, brands, and categories
         $shoppinglistWithDetails = $shoppinglist->load(['products.brand', 'products.category']);

         // Redirect with success message
        return redirect()->route('productlist.index')->with('success', 'Product List created successfully.');
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shoppinglist $shoppinglist)
    {
        // Detach all associated tags
       $shoppinglist->products()->detach();

       // Delete the news item
       $shoppinglist->delete();

       return redirect()->route('shoppinglist.index');
    }
}
