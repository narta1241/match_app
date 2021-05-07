<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = ['blocked_user_id', 'blocking_user_id'];
}
