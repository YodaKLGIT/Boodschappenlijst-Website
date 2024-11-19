<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category; // Ensure you are using the correct model for categories
use App\Models\Productlist; // Ensure you are using the correct model for lists
use Illuminate\Support\Facades\Auth;
use App\Services\JumboService;

class ProductController extends Controller
{
    protected $jumboService;

    public function __construct(JumboService $jumboService)
    {
        $this->jumboService = $jumboService;
    }

    public function index(Request $request)
    {
        // Fetch all brands
        $brands = Brand::all();

        // Fetch all categories
        $categories = Category::all();

        // Fetch all product lists owned by or shared with the authenticated user
        $lists = Productlist::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        })->orWhereHas('sharedUsers', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        // Fetch products from the Jumbo API
        $products = $this->jumboService->getAllAvailableProducts();

        // Optionally, you can apply filters here if needed
        // For example, if you want to filter products based on search, category, or brand
        // You can implement filtering logic similar to what you had before

        return view('products.index', compact('products', 'brands', 'categories', 'lists'));
    }
}