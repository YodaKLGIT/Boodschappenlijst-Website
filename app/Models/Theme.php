<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'strap_color', 'body_color'];

    public function lists()
    {
        return $this->belongsToMany(ListItem::class, 'list_theme', 'theme_id', 'list_id');
    }
}

