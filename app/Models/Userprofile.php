<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userprofile extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'profile_name',
        'picture',
        'link_x',
        'link_fb',
        'link_insta',
        'birth_date',
        'state',
        'number_of_child',
        'introduction',
        'topic',
        'hobby',
        'easy_to_talk',
    ];

    
    public function user()
    {
    return $this->belongsTo(User::class);
    }

    // Userprofileに関連するイベントを取得
    public function events()
    {
        return $this->hasMany(Event::class, 'user_id', 'user_id');
    }

    public function interests()
    {
    return $this->belongsToMany(Interest::class, 'interest_user', 'user_profile_id', 'interest_id');
    }  

    public function children()
    {
    return $this->hasMany(Child::class);
    }

}
