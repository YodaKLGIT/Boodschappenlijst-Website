<?php

namespace App\Services\Contracts;

use App\Models\ListItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

interface ListServiceInterface
{
    public function filter(Request $request);
    public function removeProductFromList(ListItem $list, Product $product);
    public function updateName(Request $request, ListItem $listItem);
    public function toggleFavorite(ListItem $listItem);
    public function getFavoriteLists();
    public function Newproduct(ListItem $listItem, Product $product);
    public function getAllBrands();
    public function getAllCategories();
}


