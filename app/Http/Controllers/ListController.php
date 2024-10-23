<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ListItem;
use App\Models\Brand; // Make sure to import the Brand model
use App\Models\Category; // Make sure to import the Category model
use Illuminate\Support\Facades\Log;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Assuming you have a method to filter product lists
        $productlists = $this->filter($request);
        
        // Get all brands and categories for filtering
        $brands = Brand::all(); // Retrieve all brands
        $categories = Category::all(); // Retrieve all categories

        // Group products by category
        $groupedProducts = Product::with(['brand', 'category'])->get()->groupBy('category.name');

        return view('lists.index', compact('productlists', 'groupedProducts', 'brands', 'categories'));
    }

    public function filter(Request $request)
    {
        $sort = $request->input('sort', 'title');
        $search = $request->input('search');
        $brandId = $request->input('brand'); // Get the selected brand ID
        $categoryId = $request->input('category'); // Get the selected category ID

        $query = ListItem::query();

        // Add search functionality
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%'); // Adjust the field name as necessary
        }

        // Filter by brand if selected
        if ($brandId) {
            $query->whereHas('products', function ($q) use ($brandId) {
                $q->where('brand_id', $brandId);
            });
        }

        // Filter by category if selected
        if ($categoryId) {
            $query->whereHas('products', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        // Apply sorting based on the selected option
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

        // Fetch the product lists with eager loading
        $productlists = $query->with(['products.brand', 'products.category', 'theme'])->get();

        // Check if there are no results and redirect back if necessary
        if ($productlists->isEmpty() && $search) {
            return redirect()->route('lists.index')->with('message', 'No product lists found for "' . $search . '".');
        }

        // Pass the product lists and search term to the view
        return view('lists.index', [
            'productlists' => $productlists,
            'search' => $search,
            'brands' => Brand::all(), // Pass all brands for the filter
            'categories' => Category::all(), // Pass all categories for the filter
        ]);
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
