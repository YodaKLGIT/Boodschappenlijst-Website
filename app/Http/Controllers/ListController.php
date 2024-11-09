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
        $user = Auth::user(); // Get the logged-in user

        // Call the filter method with the request
        $listsQuery = $this->listService->filter($request)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id) // Lists owned by the user
                      ->orWhereHas('sharedUsers', function ($q) use ($user) {
                          $q->where('user_id', $user->id); // Lists shared with the user
                      });
            });

        if (!$request->routeIs('lists.favorites')) {
            $listsQuery = $listsQuery->where('is_favorite', false); // Exclude favorites on normal index
        }

        // Debugging: Check if $listsQuery is a valid query builder
        if (!($listsQuery instanceof \Illuminate\Database\Eloquent\Builder)) {
            throw new \Exception('Invalid query builder instance');
        }

        $lists = $listsQuery->get();

        // Get all brands and categories for filtering
        $brands = Brand::all();
        $categories = Category::all();

        // Group products by category
        $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');

        return view('lists.index', compact('lists', 'groupedProducts', 'brands', 'categories'));
    }




    public function removeProductFromList(ListItem $list, Product $product)
    {
        // Call the service method to remove the product
        $message = $this->listService->removeProductFromList($list, $product);

        // Redirect back with a success message
        return redirect()->back()->with('success', $message);
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
        $user = Auth::user(); // Get the logged-in user

        // Fetch only favorite lists that the user is connected to
        $lists = ListItem::where('is_favorite', true)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id) // Lists owned by the user
                      ->orWhereHas('sharedUsers', function ($q) use ($user) {
                          $q->where('user_id', $user->id); // Lists shared with the user
                      });
            })
            ->get();

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



