<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Note;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'user_id');
    }
    
    public function shoppinglists()
    {
        return $this->belongsToMany(Shoppinglist::class, 'user_lists', 'user_id', 'list_id')
            ->withTimestamps();
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'recipient_id', 'id');
    }
    
    public function userList()
    {
        return $this->belongsToMany(ListItem::class, 'user_list', 'user_id', 'list_id');
    }
}
