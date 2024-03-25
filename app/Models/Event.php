<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['start_date', 'comment', 'user_id'/* 他のフィールド名 */];

    
    // Eventが属するUserprofileを取得
    public function userprofile()
    {
        return $this->belongsTo(Userprofile::class, 'user_id', 'user_id');
    }

    public function books()
    {
    return $this->hasMany(Book::class, 'event_id');
    }

    public function bookings()
    {
    return $this->hasMany(Book::class, 'event_id');
    }


}
