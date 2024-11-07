<?php

namespace App\Http\Controllers;

use App\Models\Services\ListService;
use App\Models\ListItem;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category; 
use Illuminate\Http\Request;
use App\Http\Requests\Auth\ProductlistRequestForm;
use Illuminate\Validation\ValidationException;

class ListController extends Controller
{
    protected $listService;

    // Type-hinting ListService in the constructor
    public function __construct(ListService $listService) 
    {
        $this->listService = $listService;
    }
    
    public function index(Request $request)
    {
        // Use the ListService to filter product lists based on request parameters
        $productlists = $this->listService->filter($request); // Fixed casing
        
        // Get all brands and categories for filtering
        $brands = Brand::all(); // Retrieve all brands
        $categories = Category::all(); // Retrieve all categories

        // Group products by category
        $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');

        return view('lists.index', compact('productlists', 'groupedProducts', 'brands', 'categories'));
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
       return view('lists.create', compact('groupedProducts'));
    }
    /**
     * Store a newly created resource in storage.
     */
    

     public function store(ProductlistRequestForm $request)
     {
         // Validate the request data

         $validatedData = $request->validate();
     
         // Create a new ProductList with timestamps
         $productlist = ListItem::create([
             'name' => $validatedData['name'],
             'created_at' => now(),
             'updated_at' => now(),
         ]);
     

         $validated = $request->validated();

         // Check for uniqueness
         if (ListItem::where('name', $validated['name'])->exists()) {
             throw ValidationException::withMessages([
                 'name' => ['A product list with this name already exists.'],
             ]);
         }

         // Create a new ProductList
         $productlist = ListItem::create(['name' => $validated['name']]);


         // Prepare data for attaching products
         $productsData = [];
         foreach ($validated['product_ids'] as $productId) {
             // Check if quantity is set for this productId, if not set it to 0
             $productsData[$productId] = ['quantity' => $validated['quantities'][$productId] ?? 0];
         }

         // Attach products with quantities
         $productlist->products()->attach($productsData);

         // Redirect with success message
         return redirect()->route('lists.index')->with('success', 'Product List created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ListItem $productlist)
    {
        // Eager load the products along with their brand and category, and the theme for the product list
        
       
        $productlist->load(['products.brand', 'products.category', 'theme']);

        return view('lists.show', compact('productlist')); 
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListItem $productlist)
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
    public function update(ProductlistRequestForm $request, ListItem $productlist)
    {
        // Validate the request data
        $validatedData = $request->validated();

        // Check for uniqueness, excluding the current product list
        if (ListItem::where('name', $validatedData['name'])
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
        return redirect()->route('lists.index')->with('success', 'List updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(ListItem $productlist)
    {
        // Detach all associated tags
       $productlist->products()->detach();

       // Delete the news item
       $productlist->delete();

       return redirect()->route('lists.index');
    }

    /*  Additional functions */ 
    public function removeProductFromList(ListItem $list, Product $productId)
    {
        // Call the service method to remove the product
        $message = $this->listService->removeProductFromList($list, $productId);

       // Redirect back with a success message
       return redirect()->route('lists.index', [$list->id])
        ->with('success', $message);
    } 

    public function updateName(Request $request, ListItem $listItem)
    {
        if($this->listService->updateName($request, $listItem ))
        {
            return redirect()->back()->with('success', 'Favorite status updated successfully.');
        }
        else 
        {
            return redirect()->back()->withErrors(['message' => 'Failed to update favorite status.']);
        }
    }

    public function toggleFavorite(Request $request, ListItem $listItem)
    {

        if($this->listService->toggleFavorite($request, $listItem ))
        {
            return redirect()->back()->with('success', 'Favorite status updated successfully.');
        }
        else 
        {
            return redirect()->back()->withErrors(['message' => 'Failed to update favorite status.']);
        }
    }

}

