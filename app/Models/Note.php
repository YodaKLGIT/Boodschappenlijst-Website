<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['title', 'description', 'user_id', 'list_id'];

    public function shoppinglist()
    {
        return $this->belongsTo(Shoppinglist::class, 'list_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}