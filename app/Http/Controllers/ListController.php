<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ListItem;
use Illuminate\Support\Facades\Log;

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
        $search = $request->input('search');

        $query = ListItem::query();

        // Add search functionality
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%'); // Adjust the field name as necessary
        }

        switch ($sort) {
            case 'last_added':
                $query->orderBy('created_at', 'desc');
                break;
            case 'last_updated':
                $query->orderBy('updated_at', 'desc');
                break;
            case 'product_count':
                $query->withCount('products')
                      ->orderBy('products_count', 'desc');
                break;
            default:
                $query->orderBy('name');
        }

        return $query->get();
    }

    /**
     * Detach a product from the list.
     */
    public function removeProductFromList(ListItem $list, $productId)
    {
        // Detach the specified product
        $list->products()->detach($productId);

        // Redirect back with a success message
        return redirect()->route('lists.index', [$list->id])
            ->with('success', 'Product detached successfully.');
    }
}
