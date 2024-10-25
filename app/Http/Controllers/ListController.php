<?php

namespace App\Http\Controllers;

use App\Models\Services\ListService;

use App\Models\Product;
use App\Models\ListItem;
use App\Models\Brand; 
use App\Models\Category; 
use Illuminate\Http\Request;

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

    public function removeProductFromList(ListItem $list, $productId)
    {
        // Call the service method to remove the product
        $message = $this->listService->removeProductFromList($list, $productId);

       // Redirect back with a success message
       return redirect()->route('lists.index', [$list->id])
        ->with('success', $message);
    } 
}

