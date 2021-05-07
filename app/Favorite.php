<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['profile_id', 'user_id'];
    
    public function profile()
    {
        return $this->belongsTo('App\Profile', 'profile_id', 'user_id');
    }
     public function profile_favorited()
    {
        return $this->belongsTo('App\Profile', 'user_id', 'user_id');
    }
     
}
