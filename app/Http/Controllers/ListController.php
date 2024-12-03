<?php

namespace App\Http\Controllers;
use App\Services\Contracts\ListServiceInterface;


use Illuminate\Support\Facades\Auth; // Add this line

use App\Models\Product;
use App\Models\ListItem;
use App\Models\Brand;
use App\Models\Category;

use Illuminate\Http\Request;

class ListController extends Controller
{

    protected $listService;

    public function __construct(ListServiceInterface $listService)
    {
        $this->listService = $listService;
    }
   
    public function index(Request $request)
{
    $user = Auth::user(); // Get the logged-in user

    // Get lists owned by or shared with the user
    // Load lists with relationships
    $listsQuery = ListItem::with(['theme', 'sharedUsers']) // Eager-load theme and sharedUsers
        ->where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhereHas('sharedUsers', function ($q) use ($user) {
                      $q->where('user_id', $user->id);
                  });
        });

    // Apply filter using the list service
    $this->listService->filter($request, $listsQuery);

    // Use distinct to ensure we don't get repeated lists
    $lists = $listsQuery->get(); // Get the results after applying the query and filters

    // Fetch all brands and categories for filtering options
    $brands = Brand::all();
    $categories = Category::all();

    // Group products by category for the view
    $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');

    // Return the view with the necessary data
    return view('lists.index', compact('lists', 'groupedProducts', 'brands', 'categories', 'user'));
}


}

