<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = ['blocked_user_id', 'blocking_user_id'];
    
    public function profile(){
        return $this->belongsTo('App\Profile', 'blocked_user_id');
    }
}
