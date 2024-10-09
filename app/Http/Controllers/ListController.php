<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

use App\Models\ListItem;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productlists = $this->filter($request);
        $productlists->load(['products.brand', 'products.category']);
        
        $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');

        return view('lists.index', compact('productlists', 'groupedProducts'));
    }

    public function filter(Request $request)
    {
        $sort = $request->input('sort', 'title');

        $query = ListItem::query();

        switch ($sort) {
            case 'last_added':
                $query->orderBy('created_at', 'desc');
                break;
            case 'last_updated':
                $query->orderBy('updated_at', 'desc');
                break;
            default:
                $query->orderBy('name');
        }

        return $query->get();
    }
}