<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }
    
    public function shoppinglist()
    {
        return $this->belongsTo(user::class, 'note_id');
    }
}
