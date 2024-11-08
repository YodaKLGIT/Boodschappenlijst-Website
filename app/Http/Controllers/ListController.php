<?php

namespace App\Http\Controllers;

use App\Models\Services\ListService;
use Illuminate\Support\Facades\Auth; // Add this line

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
        $lists = $this->listService->filter($request); // Fixed casing

        if (!$request->routeIs('lists.favorites')) {
            $lists = $lists->where('is_favorite', false); // Exclude favorites on normal index
        }
        
        // Get all brands and categories for filtering
        $brands = Brand::all(); // Retrieve all brands
        $categories = Category::all(); // Retrieve all categories

        // Group products by category
        $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');

        return view('lists.index', compact('lists', 'groupedProducts', 'brands', 'categories'));
    }

    public function removeProductFromList(ListItem $list, $productId)
    {
        // Detach the specified product
        $list->products()->detach($productId);

        // Redirect back with a success message
        return redirect()->route('lists.index', [$list->id])
            ->with('success', 'Product detached successfully.');
    }

    public function updateName(Request $request, ListItem $list)
    {
        if($this->listService->updateName($request, $list))
        {
            return redirect()->back()->with('success', 'Favorite status updated successfully.');
        }
        else 
        {
            return redirect()->back()->withErrors(['message' => 'Failed to update favorite status.']);
        }
    }

    public function ShowFavorites(Request $request)
    {
        $user = Auth::user();  

        // Fetch only favorite lists
        $lists = ListItem::where('is_favorite', true)->get();

        // Return the view with the filtered lists
        return view('lists.index', compact('lists'));
    }

    public function toggleFavorite(Request $request, ListItem $list)
    {
        if($this->listService->toggleFavorite($request, $list))
        {
            return redirect()->back()->with('success', 'Favorite status updated successfully.');
        }
        else 
        {
            return redirect()->back()->withErrors(['message' => 'Failed to update favorite status.']);
        }
    } 
}