<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all categories
        $categories = Category::all();
        
        // Fetch all brands
        $brands = Brand::all();

        // Fetch products with optional search and filters
        $products = Product::when($request->search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->when($request->category, function ($query, $categoryId) {
            return $query->where('category_id', $categoryId);
        })->when($request->brand, function ($query, $brandId) {
            return $query->where('brand_id', $brandId);
        });

        // Apply sorting if specified
        if ($request->sort === 'asc') {
            $products = $products->orderBy('name', 'asc');
        } elseif ($request->sort === 'desc') {
            $products = $products->orderBy('name', 'desc');
        }

        $products = $products->get();

        // Return the products view with the fetched products, categories, brands, and request
        return view('products.index', compact('products', 'categories', 'brands', 'request'));
    }
}
