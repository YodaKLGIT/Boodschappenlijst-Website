<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    protected $table = 'lists';  

    public function notes()
    {
        return $this->hasMany(User::class, 'note_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_lists', 'shoppinglist_id', 'product_id')->withPivot('quantity');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_lists', 'shoppinglist_id', 'user_id');
    }
    
}
