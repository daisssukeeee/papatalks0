<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    // モデルと関連するテーブル名
    protected $table = 'interests';

    public function userProfiles()
    {
        return $this->belongsToMany(UserProfile::class, 'interest_user', 'interest_id', 'user_profile_id');
    }


}
