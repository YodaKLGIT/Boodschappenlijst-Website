<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ListFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


use Illuminate\Database\Eloquent\SoftDeletes;

   class Productlist extends Model
   {
       use HasFactory;
       
    protected $fillable = ['name', 'theme_id', 'is_favorite', 'user_id'];

    protected $table = 'lists';  // This should match the lists table

    public function notes()
    {
        return $this->hasMany(Note::class, 'list_id');
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

    

    public function sharedUsers()
    {
        return $this->belongsToMany(User::class, 'user_list', 'list_id', 'user_id');
    }

    public function scopeAccessibleBy($query, $user)
    {
        return $query->where('user_id', $user->id)
                     ->orWhereHas('sharedUsers', function ($query) use ($user) {
                         $query->where('users.id', $user->id);
                     });
    }
    
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getOwnerAttribute()
    {
        return $this->users()->orderBy('user_list.created_at')->first();
    }

}
