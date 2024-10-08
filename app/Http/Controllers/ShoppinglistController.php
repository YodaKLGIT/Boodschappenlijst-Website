<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ShoppinglistRequest;
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
    public function create()
    {
       // You can retrieve all products to pass to the view, if needed
       $products = Product::all();

       // Return the view to create a new shopping list
      return view('shoppinglist.create', compact('products'));
    }

    

    /**
     * Store a newly created resource in storage.
     */
    

     public function store(ShoppinglistRequest $request)
     {
         // Validate the request data
         $validatedData = $request->validate();
     
         // Create a new ShoppingList
         $shoppinglist = Shoppinglist::create([
             'name' => $validatedData['name'],
         ]);
     
         // Prepare data for attaching products
         $productData = [];
         foreach ($validatedData['product_ids'] as $productId) {
             // Check if quantity is set for this productId, if not set it to null or a default value
             $quantity = isset($validatedData['quantities'][$productId]) ? $validatedData['quantities'][$productId] : null;
             $productData[$productId] = ['quantity' => $quantity];
         }
     
         // Attach products with quantities
         $shoppinglist->products()->attach($productData);
     
         // Redirect with success message
         return redirect()->route('shoppinglist.index')->with('success', 'Product List created successfully.');
     }
     

    /**
     * Display the specified resource.
     */
    public function show(Shoppinglist $shoppinglist)
    {
        $products = $shoppinglist->products;

        return view('shoppinglist.show', compact('shoppinglist', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shoppinglist $shoppinglist)
    {  
       $products = Product::with(['brand', 'category'])->get(); 

       $shoppinglist = $shoppinglist->load(['products.brand', 'products.category']);

       return view('shoppinglist.edit', compact('shoppinglist', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShoppinglistRequest $request, Shoppinglist $shoppinglist)
    {
        // Validate the request data
        $validatedData = $request->validate();

        // Create a new ProductList
        $shoppinglist->name =  $validatedData['name'];
        $shoppinglist->save();

        // Prepare data for attaching products
        $productData = [];
        foreach ($validatedData['product_ids'] as $productId) {
            // Check if quantity is set for this productId, if not set it to null or a default value
            $quantity = isset($validatedData['quantities'][$productId]) ? $validatedData['quantities'][$productId] : null;
            $productData[$productId] = ['quantity' => $quantity];
        }
        // Attach products with quantities
        $shoppinglist->products()->sync($productData);

         // Step 3: Retrieve the updated shopping list with related products, brands, and categories
        $shoppinglist->load(['products.brand', 'products.category']);

         // Redirect with success message
        return redirect()->route('shoppinglist.index')->with('success', 'Product List created successfully.');
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

