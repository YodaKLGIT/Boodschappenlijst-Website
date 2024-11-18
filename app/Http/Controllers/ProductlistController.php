<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Productlist;
use App\Http\Requests\Auth\ProductlistRequestForm;

use Illuminate\Validation\ValidationException;

class ProductlistController extends Controller
{
    

    
   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       // Eager load products with their brands and categories
       $products = Product::with(['brand', 'category'])->get();

       // Group products by category name 
       $groupedProducts = $products->groupBy('category.name');

       // Return the view to create a new product list with grouped products
       return view('productlist.create', compact('groupedProducts'));
    }


    

    /**
     * Store a newly created resource in storage.
     */
    

     public function store(ProductlistRequestForm $request)
     {
         // Validate the request data

         $validatedData = $request->validate();
     
         // Create a new ProductList with timestamps and is_new
         $productlist = Productlist::create([
             'name' => $validatedData['name'],
             'is_new' => $validatedData['is_new'] ?? false, // Handle is_new
             'created_at' => now(),
             'updated_at' => now(),
         ]);
     

         $validated = $request->validated();

         // Check for uniqueness
         if (Productlist::where('name', $validated['name'])->exists()) {
             throw ValidationException::withMessages([
                 'name' => ['A product list with this name already exists.'],
             ]);
         }

         // Create a new ProductList
         $productlist = Productlist::create(['name' => $validated['name']]);


         // Prepare data for attaching products
         $productsData = [];
         foreach ($validated['product_ids'] as $productId) {
             // Check if quantity is set for this productId, if not set it to 0
             $productsData[$productId] = ['quantity' => $validated['quantities'][$productId] ?? 0];
         }

         // Attach products with quantities
         $productlist->products()->attach($productsData);

         // Redirect with success message
         return redirect()->route('productlist.index')->with('success', 'Product List created successfully.');
     }
     

    /**
     * Display the specified resource.
     */
    public function show(Productlist $productlist)
    {
        // Eager load the products along with their brand and category, and the theme for the product list
        $productlist->load(['products.brand', 'products.category', 'theme']);

        return view('productlist.show', compact('productlist'));
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

       return view('product.edit', compact('productlist', 'products', 'groupedProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductlistRequestForm $request, Productlist $productlist)
    {
        // Validate the request data
        $validatedData = $request->validated();

        // Check for uniqueness, excluding the current product list
        if (Productlist::where('name', $validatedData['name'])
                       ->where('id', '!=', $productlist->id)
                       ->exists()) {
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
            // Check if quantity is set for this productId, if not set it to null or a default value
            $quantity = isset($validatedData['quantities'][$productId]) ? $validatedData['quantities'][$productId] : null;
            $productData[$productId] = ['quantity' => $quantity];
        }
        // Attach products with quantities
        $productlist->products()->sync($productData);

        // Retrieve the updated product list with related products, brands, and categories
        $productlist->load(['products.brand', 'products.category']);

        // Redirect with success message
        return redirect()->route('productlist.index')->with('success', 'Product List updated successfully.');
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

       return redirect()->route('lists.index');
    }
}
