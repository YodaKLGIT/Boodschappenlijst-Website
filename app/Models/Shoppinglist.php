<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shoppinglist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date', 'category_id', 'brand_id'];
}
