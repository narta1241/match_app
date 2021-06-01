<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FootPrint extends Model
{
     protected $fillable = ['footed_user_id', 'footting_user_id'];
     
     protected $table = 'footprints';
     
   public function profile()
    {
        return $this->belongsTo('App\Profile', 'footting_user_id', 'user_id');
    }
}
