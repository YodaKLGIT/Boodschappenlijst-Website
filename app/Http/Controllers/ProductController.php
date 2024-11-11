<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category; // Ensure you are using the correct model for categories
use App\Models\Productlist; // Ensure you are using the correct model for lists
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
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

        // Fetch products with optional search and filters
        $products = Product::query();

        // Apply search filter if specified
        if ($request->search) {
            $products->where('name', 'like', "%{$request->search}%");
        }

        // Apply category filter if specified
        if ($request->category) {
            $products->where('category_id', $request->category);
        }

        // Apply brand filter if specified
        if ($request->brand) {
            $products->where('brand_id', $request->brand);
        }

        // Get the paginated result
        $products = $products->paginate(10);

        return view('products.index', compact('products', 'brands', 'categories', 'lists'));
    }
}