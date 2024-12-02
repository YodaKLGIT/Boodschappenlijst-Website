<?php

namespace App\Http\Controllers;
use App\Services\Contracts\ListServiceInterface;
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

    public function __construct(ListServiceInterface $listService)
    {
        $this->listService = $listService;
    }
   
    public function index(Request $request)
    {
    $user = Auth::user(); // Get the logged-in user

    // Get lists owned by or shared with the user
     // Load lists with relationships
     $listsQuery = ListItem::with('theme') // Eager-load theme
     ->where(function ($query) use ($user) {
         $query->where('user_id', $user->id)
               ->orWhereHas('sharedUsers', function ($q) use ($user) {
                   $q->where('user_id', $user->id);
               });
     });

    // Use distinct to ensure we don't get repeated lists
    $lists = $listsQuery->with('sharedUsers')->get();

    // Fetch all brands and categories for filtering options
    $brands = Brand::all();
    $categories = Category::all();

    // Group products by category for the view
    $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');

    // Return the view with the necessary data
    return view('lists.index', compact('lists', 'groupedProducts', 'brands', 'categories', 'user'));
    }
}

