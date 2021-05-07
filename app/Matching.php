<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Favorite;

class Matching extends Model
{
     protected $fillable = ['user_id', 'receive_user_id'];
     
     public static function match($login_user_id, $match_user_id){
         //いいねした
         $favoritting = Favorite::where('user_id', $login_user_id)->where('profile_id', $match_user_id)->first();
         //いいねされた
         $favorited = Favorite::where('profile_id', $login_user_id)->where('user_id', $match_user_id)->first();
         if($favorited && $favoritting){
            $matching = new Matching();
            $match = $matching->where('user_id', $login_user_id)->where('receive_user_id', $match_user_id)->first();
            if(!$match){
                Matching::create([
                    'user_id' => $login_user_id,
                    'receive_user_id' => $match_user_id,
                ]);
                Matching::create([
                    'user_id' => $match_user_id,
                    'receive_user_id' => $login_user_id,
                ]);
                $mailFavorittingUser = User::where('id' , $login_user_id)->first();
                $to = $mailFavorittingUser->email;
                $mail = app()->make('App\Http\Controllers\MailingController');
                $mail->matchMail($to, $login_user_id);
                $mailFavoritedUser = User::where('id' , $match_user_id)->first();
                $to = $mailFavoritedUser->email;
                $mail = app()->make('App\Http\Controllers\MailingController');
                $mail->matchMail($to, $match_user_id);
            }
         }
     }
    public function profile()
    {
        return $this->belongsTo('App\Profile', 'user_id', 'user_id');
    }
    
    public static function room($user_id,$receive_user_id)
    {
        // dump($user_id);
        // dd($receive_user_id);
        $match = new Matching;
        return $match::where('receive_user_id', $receive_user_id)->where('user_id', $user_id)->value('id');
    }
}
