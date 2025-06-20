<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Follower extends Model
{
    public  const UPDATED_AT = null;
    protected $fillable = [
        'user_id',
        'follower_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function following(){
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function followers(){
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }
}
