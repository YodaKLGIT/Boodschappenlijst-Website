<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Note;
use Illuminate\Database\Eloquent\Model;

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

    
    public function shoppingLists()
    {
        return $this->belongsToMany(ListItem::class, 'user_list', 'user_id', 'list_id');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'recipient_id', 'id');
    }
    
    public function lists()
    {
        return $this->belongsToMany(ListItem::class, 'user_list', 'user_id', 'list_id')
        ->withPivot('is_new');
    }
    public function lists()
    {
        return $this->hasMany(ListItem::class, 'user_id');
    }

    public function sharedLists()
    {
        return $this->belongsToMany(ListItem::class, 'user_list', 'user_id', 'list_id');
    }

    public function productLists()
    {
        return $this->belongsToMany(Productlist::class, 'user_list', 'user_id', 'list_id');
    }
}
