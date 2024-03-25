<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['event_id', 'user_id', 'reservation', 'status', 'zoom'];

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function event()
    {
    return $this->belongsTo(Event::class);
    }
    
}
