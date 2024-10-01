<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\brand;
use App\Models\category;
use App\Models\shoppinglist;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category_id', 'brand_id'];

    public function category()
    {
        return $this->belongsTo(category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(brand::class, 'brand_id');
    }

    public function Productlist()
    {
        return $this->belongsToMany(shoppinglist::class)->withPivot('quantity');
    }
}
