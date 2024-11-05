<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch all categories
        $categories = Category::all();

        // Pass categories to the view
        return view('home', compact('categories'));
    }
}

