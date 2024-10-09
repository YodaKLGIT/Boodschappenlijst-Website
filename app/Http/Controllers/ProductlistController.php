<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Productlist;

class ProductlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $Productlists = Productlist::with(['products.brand', 'products.category'])->get();

        
        $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');
   
        return view('productlist.index', compact('productlists', 'groupedProducts'));
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

       // Return the view to create a new product list with grouped products
       return view('productlist.create', compact('groupedProducts'));
    }


    

    /**
     * Store a newly created resource in storage.
     */
    

     public function store(Request $request)
     {
         // Validate the request data
         $validatedData = $request->validate([
             'name' => 'required|string|max:255',
             'product_ids' => 'nullable|array|max:255',
             'product_ids.*' => 'exists:products,id',
             'quantities' => 'nullable|array',
             'quantities.*' => 'nullable|integer|min:1',
             'list_id' => 'nullable|exists:product_lists,id',
         ]);
     
         // Create a new ProductList
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
    public function show(Shoppinglist $productlist)
    {
        $products = $productlist->products()->with(['brand', 'category'])->get();

        return view('productlist.show', compact('productlist', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shoppinglist $shoppinglist)
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
    public function update(Request $request, Shoppinglist $productlist)
    {
          // Validate the request data
          $validatedData = $request->validate([
             'name' => 'required|string|max:255',
             'product_ids' => 'nullable|array|max:255',
             'product_ids.*' => 'exists:products,id',
             'quantities' => 'nullable|array',
             'quantities.*' => 'nullable|integer|min:1',
             'list_id' => 'nullable|exists:product_lists,id',
        ]);

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

         // Step 3: Retrieve the updated product list with related products, brands, and categories
        $productlist->load(['products.brand', 'products.category']);

         // Redirect with success message
       
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
