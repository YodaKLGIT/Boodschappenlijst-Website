<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Productlist;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = ['list_id', 'sender_id', 'recipient_id', 'status'];

    public function list()
    {
        return $this->belongsTo(Productlist::class, 'list_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}