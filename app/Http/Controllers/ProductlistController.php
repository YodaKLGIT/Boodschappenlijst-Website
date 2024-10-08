<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ProductlistRequestForm;
use App\Models\Product;
use App\Models\Productlist;

class ShoppinglistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $productlists = Productlist::with(['products.brand', 'products.category'])->get();
        $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');
   
        return view('productlist.index', compact('productlists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       // Eager load products with their brands and categories
       $products = Product::with(['brand', 'category'])->get();

       // Group products by category name 
       $groupedProducts = $products->groupBy('category.name');

       // Return the view to create a new shopping list with grouped products
       return view('productlist.create', compact('groupedProducts'));
    }


    

    /**
     * Store a newly created resource in storage.
     */
    

     public function store(ProductlistRequestForm $request)
     {
         // Validate the request data
         $validatedData = $request->validate();
     
         // Create a new ShoppingList
         $productlist = Productlist::create([
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
         $productlist->products()->attach($productData);
     
         // Redirect with success message
         return redirect()->route('productlist.index')->with('success', 'Product List created successfully.');
     }
     

    /**
     * Display the specified resource.
     */
    public function show(Productlist $productlist)
    {
            $products = $productlist->products()->with(['brand', 'category'])->get();

        return view('productlist.show', compact('productlist', 'products'));
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

       return view('productlist.edit', compact('productlist', 'products', 'groupedProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductlistRequestForm $request, Productlist $productlist)
    {
        // Validate the request data
        $validatedData = $request->validate();

        // Create a new ProductList
        $productlist->name =  $validatedData['name'];
        $productlist->save();

        // Prepare data for attaching products
        $productData = [];
        foreach ($validatedData['product_ids'] as $productId) {
            // Check if quantity is set for this productId, if not set it to null or a default value
            $quantity = isset($validatedData['quantities'][$productId]) ? $validatedData['quantities'][$productId] : null;
            $productData[$productId] = ['quantity' => $quantity];
        }
        // Attach products with quantities
        $productlist->products()->sync($productData);

         // Step 3: Retrieve the updated shopping list with related products, brands, and categories
        $productlist->load(['products.brand', 'products.category']);

         // Redirect with success message
        return redirect()->route('productlist.index')->with('success', 'Product List created successfully.');
      }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productlist $productlist)
    {
        // Detach all associated tags
       $productlist->products()->detach();

       // Delete the news item
       $productlist->delete();

       return redirect()->route('productlist.index');
    }
}
