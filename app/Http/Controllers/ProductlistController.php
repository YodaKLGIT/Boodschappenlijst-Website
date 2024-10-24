<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Productlist;
use App\Http\Requests\Auth\ProductlistRequestForm;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProductlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productlists = Productlist::with(['products.brand', 'products.category'])->get();
        $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');

        return view('lists.index', compact('productlists', 'groupedProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::with(['brand', 'category'])->get();
        $groupedProducts = $products->groupBy('category.name');

        return view('productlist.create', compact('groupedProducts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductlistRequestForm $request)
    {
        $validatedData = $request->validated();

        // Check for uniqueness
        if (Productlist::where('name', $validatedData['name'])->exists()) {
            throw ValidationException::withMessages([
                'name' => ['A product list with this name already exists.'],
            ]);
        }

        // Create a new ProductList
        $productlist = Productlist::create(['name' => $validatedData['name']]);

        // Prepare data for attaching products
        $productsData = [];
        foreach ($validatedData['product_ids'] as $productId) {
            // Check if quantity is set for this productId, if not set it to 0
            $productsData[$productId] = ['quantity' => $validatedData['quantities'][$productId] ?? 0];
        }

        // Attach products with quantities
        $productlist->products()->attach($productsData);

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
        $groupedProducts = $products->groupBy('category.name');

        return view('product.edit', compact('productlist', 'products', 'groupedProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductlistRequestForm $request, Productlist $productlist)
    {
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

        $productlist->name = $validatedData['name'];
        $productlist->updated_at = now();
        $productlist->save();

        // Prepare data for attaching products
        $productData = [];
        foreach ($validatedData['product_ids'] as $productId) {
            $quantity = $validatedData['quantities'][$productId] ?? null;
            $productData[$productId] = ['quantity' => $quantity];
        }

        // Sync products with quantities
        $productlist->products()->sync($productData);

        return redirect()->route('productlist.index')->with('success', 'Product List updated successfully.');
    }

    /**
     * Add a product to the list.
     */
    public function add(Request $request)
    {
        // try {
        // Validate the request data
        $request->validate([
            'list_id' => 'required|exists:lists,id',
            'product_id' => 'required|exists:products,id',
        ]);

        // Find the product list entry
        $productListEntry = ProductList::where('list_id', $request->list_id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($productListEntry) {
            // If the product is already in the list, update the quantity
            $productListEntry->quantity += 1;
            $productListEntry->save();
            Log::info('Product quantity updated in the list.', ['list_id' => $request->list_id, 'product_id' => $request->product_id]);
        } else {
            // If the product is not in the list, create a new entry
            ProductList::create([
                'list_id' => $request->list_id,
                'product_id' => $request->product_id,
                'quantity' => 1
            ]);
            Log::info('Product added to the list successfully.', ['list_id' => $request->list_id, 'product_id' => $request->product_id]);
        }

        return redirect()->back()->with('success', 'Product added to the list successfully.');
        // } catch (\Exception $e) {
        //     Log::error('Failed to add product to the list.', [
        //         'error' => $e->getMessage(),
        //         'trace' => $e->getTraceAsString()
        //     ]);
        //     return redirect()->back()->with('error', 'Failed to add product to the list.');
        // }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productlist $productlist)
    {
        $productlist->products()->detach();
        $productlist->delete();

        return redirect()->route('lists.index')->with('success', 'Product List deleted successfully.');
    }
}
