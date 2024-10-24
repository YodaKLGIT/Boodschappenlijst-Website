<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ListItem;
use App\Models\Productlist;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all categories
        $categories = Category::all();

        // Fetch all brands
        $brands = Brand::all();

        // Fetch all product lists

        // Get all available product lists
        $lists = ListItem::all();

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

        // Apply sorting if specified
        if ($request->sort === 'asc') {
            $products->orderBy('name', 'asc');
        } elseif ($request->sort === 'desc') {
            $products->orderBy('name', 'desc');
        }

        // Get all filtered and sorted products
        $products = $products->get();

        // Pass data to the view
        return view('products.index', compact('products', 'categories', 'brands', 'request', 'lists'));
    }
}
