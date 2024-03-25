<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class);
    }
}
