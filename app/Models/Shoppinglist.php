<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoppinglist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date'];


    protected $table = 'lists';  

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_list', 'list_id', 'product_id')
                    ->withPivot('quantity');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
}
