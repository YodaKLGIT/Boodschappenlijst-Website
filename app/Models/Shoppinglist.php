<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoppinglist extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    protected $table = 'lists';  // Specify the correct table name

    public function notes()
    {
        return $this->hasMany(User::class, 'note_id');
    }

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
