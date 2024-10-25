<?php

namespace App\Http\Controllers;

use App\Models\Services\ListFilterService;
use App\Models\Product;
use App\Models\ListItem;
use App\Models\Brand; 
use App\Models\Category; 
use Illuminate\Http\Request;

class ListController extends Controller
{
    protected $listFilterService;

    public function __construct(ListFilterService $listFilterService)
    {
        $this->listFilterService = $listFilterService;
    }
    
    public function index(Request $request)
    {
        // Use the ListFilterService to filter product lists based on request parameters
        $productlists = $this->listFilterService->filter($request);
        
        // Get all brands and categories for filtering
        $brands = Brand::all(); // Retrieve all brands
        $categories = Category::all(); // Retrieve all categories

        // Group products by category
        $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');

        return view('lists.index', compact('productlists', 'groupedProducts', 'brands', 'categories'));
    }

    /**
     * Detach a product from the list.
     */
    public function removeProductFromList(ListItem $list, $productId)
    {
        // Detach the specified product
        $list->products()->detach($productId);

        // Redirect back with a success message
        return redirect()->route('lists.index', [$list->id])
            ->with('success', 'Product detached successfully.');
    }
}
