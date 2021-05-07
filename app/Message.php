<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['room_id', 'user_id', 'receive_user_id', 'text', 'read_flg'];
    
     public function matching()
    {
        return $this->hasMany('App\Matching');
    }
    public function room($id)
    {
        dump($id);
        $room_id = $this->where('user_id', $id)->value('room_id');
        dd($room_id);
        return $room_id;
    }
}
