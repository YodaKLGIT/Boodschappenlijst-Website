<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductList;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category_id', 'brand_id', 'image_url'];

    // Define the relationship with the Category model
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // Ensure Category model is properly named
    }

    // Define the relationship with the Brand model
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id'); // Ensure Brand model is properly named
    }

    // Define the many-to-many relationship with the ShoppingList model
    public function productList()
    {
        return $this->belongsToMany(Productlist::class)->withPivot('quantity');
    }

    public function productListItem()
    {
        return $this->belongsToMany(ListItem::class)->withPivot('quantity');
    }

    public function lists()
    {
        return $this->belongsToMany(ProductList::class, 'product_list_product');
    }

    

}
