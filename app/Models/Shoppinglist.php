<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoppinglist extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    protected $table = 'lists';  

    public function notes()
    {
        return $this->hasMany(User::class, 'note_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_list')->withPivot('quantity');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
}
