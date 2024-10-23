<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Shoppinglist;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category_id', 'brand_id'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function shoppinglists()
    {
        return $this->belongsToMany(Shoppinglist::class, 'product_list', 'product_id', 'list_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
