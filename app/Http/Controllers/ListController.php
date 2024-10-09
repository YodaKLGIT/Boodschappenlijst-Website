<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

use App\Models\ListItem;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $productlists = ListItem::with(['products.brand', 'products.category'])->get();

        $productlists = $this->filter($request);
        
        $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');
   
        return view('lists.index', compact('productlists', 'groupedProducts'));
    }

    public function filter(Request $request)
    {
        // Get the sort option from the request
        $sort = $request->input('sort', 'title'); // Default sort by title

        // Fetch shopping lists based on the selected sort option
        switch ($sort) {
            case 'last_added':
                return ListItem::orderBy('created_at', 'desc')->get();
            case 'last_updated':
                return ListItem::orderBy('updated_at', 'desc')->get();
            default:
                return ListItem::orderBy('name')->get(); // Sort by name by default
        }
    }
}