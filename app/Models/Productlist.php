<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Productlist extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sharedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_lists', 'list_id', 'user_id')->withTimestamps();
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_list', 'list_id', 'product_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function scopeAccessibleBy($query, $user)
    {
        return $query->where('user_id', $user->id)
                     ->orWhereHas('sharedUsers', function ($query) use ($user) {
                         $query->where('users.id', $user->id);
                     });
    }

    public function notes()
{
    return $this->hasMany(Note::class, 'list_id');
}
}