<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    use HasFactory;

    protected $table = 'user_list';  

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_list', 'list_id', 'user_id')
                    ->withTimestamps();
    }
}
