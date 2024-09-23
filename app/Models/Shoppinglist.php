<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shoppinglist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date'];


    public function notes()
    {
        return $this->hasMany(user::class, 'note_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
