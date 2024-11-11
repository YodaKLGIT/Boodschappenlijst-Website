<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'strap_color',
        'body_color',
        'content_bg_color',
        'hover_color',
        'count_circle_color'
    ];

    public function lists()
    {
        return $this->hasMany(ListItem::class);
    }
}
