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
        $shoppinglists = Shoppinglist::with(['products.brand', 'products.category'])->create();

        return view('index', compact('shoppinglists'));
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
       
    
  
        return view('index', compact('shoppinglists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
