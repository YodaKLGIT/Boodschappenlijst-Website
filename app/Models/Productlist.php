<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productlist extends Model
{
    use HasFactory;

    protected $fillable = ['list_id', 'product_id', 'quantity'];

    protected $table = 'product_list';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_list', 'list_id', 'product_id', 'product_list_product')
            ->withPivot('quantity');
    }

    public function lists()
    {
        return $this->belongsToMany(Productlist::class)->withPivot('quantity');
    }
}
