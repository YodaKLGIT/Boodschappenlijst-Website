<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ListFactory;

class ListItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'theme_id', 'is_favorite' ];

    protected $table = 'lists';

    protected static function newFactory()
    {
        return ListFactory::new();
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_list', 'list_id', 'product_id')
                    ->withPivot('quantity');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_list', 'list_id', 'user_id');
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
}
