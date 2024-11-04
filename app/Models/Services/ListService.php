<?php

namespace App\Models\Services; // Ensure this is the correct namespace

use App\Models\ListItem; 
use App\Models\Brand; 
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class ListService
{
    /**
     * Filter and sort ListItems based on the request parameters.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filter(Request $request)
    {
        // Retrieve filter inputs
        $sort = $request->input('sort', 'title');  // Default sort by title
        $search = $request->input('search');        // Get the search term
        $brandId = $request->input('brand');        // Get the selected brand ID
        $categoryId = $request->input('category');  // Get the selected category ID

        // Start the query for ListItem
        $query = ListItem::query();

        // Add search functionality if a search term is provided
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%'); // Adjust the field name as necessary
        }

        // Filter by brand if a brand ID is selected
        if ($brandId) {
            $query->whereHas('products', function ($q) use ($brandId) {
                $q->where('brand_id', $brandId);
            });
        }

        // Filter by category if a category ID is selected
        if ($categoryId) {
            $query->whereHas('products', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        // Apply sorting based on the selected criteria
        switch ($sort) {
            case 'last_added':
                $query->orderBy('created_at', 'desc');
                break;
            case 'last_updated':
                $query->orderBy('updated_at', 'desc');
                break;
            case 'product_count':
                $query->withCount('products')->orderBy('products_count', 'desc');
                break;
            case 'brand':
                $query->orderBy('brand_id'); // Adjust if needed based on your database structure
                break;
            case 'category':
                $query->orderBy('category_id'); // Adjust if needed based on your database structure
                break;
            default:
                $query->orderBy('name');
        }

        // Fetch the product lists with eager loading
        return $query->with(['products.brand', 'products.category', 'theme'])->get(); // Return the filtered product lists
    }

    public function removeProductFromList(ListItem $list, $productId)
    {
        // Detach the specified product
       $list->products()->detach($productId);
    
       // Optionally return a success message or boolean
       return 'Product detached successfully.';
    }

    public function editName(ListItem $list_id)
    {
        return ListItem::find($list_id);
    }

    public function updateName(ListItem $listItem, Request $request)
{
    // Validate the incoming request
    $request->validate([
        'name' => 'required|string|max:255', // Validate the name
        'theme_id' => 'nullable|exists:themes,id', // Validate theme_id, if provided
    ]);

    // Update the name
    $listItem->name = $request->name;

    // If a theme_id is provided, update it; otherwise, retain the existing value
    if ($request->has('theme_id')) {
        $listItem->theme_id = $request->theme_id;
    }

    if ($listItem->save()) {
        Log::info('ListItem updated successfully', [
            'id' => $listItem->id, 
            'name' => $listItem->name, 
            'theme_id' => $listItem->theme_id // Log the theme_id for debugging
        ]);
    } else {
        Log::error('Failed to update ListItem', ['id' => $listItem->id]);
    }

    return true; // Indicate success
}





    /**
     * Get all brands for filtering.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllBrands()
    {
        return Brand::all();
    }

    /**
     * Get all categories for filtering.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories()
    {
        return Category::all();
    }
}


