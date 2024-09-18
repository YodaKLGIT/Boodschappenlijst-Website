<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoppinglist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date', 'category_id', 'brand_id'];

    public function notes()
    {
        return $this->hasMany(user::class, 'note_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
