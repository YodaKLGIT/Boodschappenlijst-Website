<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch all categories
        $categories = Category::all();

        // Fetch a few random products (maximum 3)
        $featuredProducts = Product::inRandomOrder()->take(3)->get();

        // Pass categories and featured products to the view
        return view('home', compact('categories', 'featuredProducts'));
    }
}