<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoppinglist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date'];


    protected $table = 'lists';  // Specify the correct table name

    public function notes()
    {
        return $this->hasMany(user::class, 'note_id');
    }

    public function products()
    {
        // Specify the foreign key names explicitly in the belongsToMany method
        return $this->belongsToMany(Product::class, 'product_list', 'list_id', 'product_id')
                    ->withPivot('quantity');
    }

   
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
