<?php
namespace App\Http\Controllers;

use App\Models\ListItem;
use App\Models\Product;
use App\Models\Theme;
use App\Models\User;
use App\Services\Contracts\ListServiceInterface;
use Illuminate\Http\Request;

class ListServiceController extends Controller
{
    protected $listService;

    public function __construct(ListServiceInterface $listService)
    {
        $this->listService = $listService;
    }

    /*
    public function listFilter(Request $request)
    {
       // Call the service to filter data
       $lists = $this->listService->filter($request);

       // Return the filtered lists to the view
       return view('lists.index', compact('lists'));
    }
    */


    /**
     * Remove a product from a list.
     *
     * @param Request $request
     * @param ListItem $listItem
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeProductFromList(ListItem $listItem, Product $product)
    {
        $result = $this->listService->removeProductFromList($listItem, $product);

        if ($result) {
            return redirect()->back()->with('success', 'Product removed successfully.');
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to remove product.']);
        }
    }

    /**
     * Update the name of a list item.
     *
     * @param Request $request
     * @param ListItem $listItem
     * @return \Illuminate\Http\RedirectResponse
     */
    
     public function updateName(Request $request, ListItem $list)
    {
        // Directly call the updateName method and check if it was successful
        if ($this->listService->updateName($request, $list)) {
        // If true, the update was successful, so redirect with a success message
        return redirect()->back()->with('success', 'List name updated successfully.');
        } else {
        // If false, the update failed, so redirect back with an error message
        return redirect()->back()->withErrors(['error' => 'Failed to update the list name.']);
        }
    }


    /**
     * Toggle the favorite status of a list item.
     *
     * @param ListItem $listItem
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleFavorite(Request $request, ListItem $list)
    {
        $result = $this->listService->toggleFavorite($request, $list);

        if ($result) {
            return redirect()->route('lists.index')->with('success', 'Favorite status updated.');
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to toggle favorite.']);
        }
    }

    /**
     * Get the favorite lists.
     *
     * @return \Illuminate\View\View
     */
    public function getFavoriteLists()
    {
        $lists = $this->listService->getFavoriteLists();

        return view('lists.index', compact('lists'));
    }

    /**
     * Add a new product to a list and update the `is_new` field.
     *
     * @param ListItem $listItem
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    
    public function markProductAsSeen(ListItem $list, Product $product)
    {
        if ($this->listService->markProductAsSeen($list, $product)) {
            return redirect()->back()->with('success', 'List name updated successfully.');
        } else {
        // If false, the update failed, so redirect back with an error message
        return redirect()->back()->withErrors(['error' => 'Failed to update the list name.']);
        }
    }
}