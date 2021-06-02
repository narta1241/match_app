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
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function reciev_user()
    {
        return $this->belongsTo('App\User', 'receive_user_id');
    }
    
    public static function room($user_id,$receive_user_id)
    {
        // dump($user_id);
        // dd($receive_user_id);
        $match = new Matching;
        return $match::where('receive_user_id', $receive_user_id)->where('user_id', $user_id)->value('id');
    }
    
    /**
     * ログインユーザーIDに紐づくマッチングデータを取得する
     * （退会ユーザーを除く）
     * @param $loginUserId ログインユーザーID
     * @return array Matching
     */
    public static function getByLoginUserId($loginUserId)
    {
        $matchingModel = Matching::where('receive_user_id', $loginUserId);
        
        $withdrawUserIds = User::wherenotnull('deleted_at')->pluck('id');
        if ($withdrawUserIds) {
            $matchingModel->wherenotin('user_id', $withdrawUserIds);
        }
        
        return $matchingModel->get();
    }
    
    /**
     * ログインユーザーIDに紐づく退会ユーザーとのマッチングデータを取得する
     * （アクティブユーザーを除く）
     * @param $loginUserId ログインユーザーID
     * 
     */
    public static function getWithdrawByLoginUserId($loginUserId)
    {
        $matchings = Matching::where('receive_user_id', $loginUserId)->get();
        
        $withdrawUserIds = [];
        foreach ($matchings as $matching) {
            $user = $matching->user;
            if (!$user->deleted_at) {
                continue;
            }
            
            # 退会ユーザーを表示する条件の日時（退会日より10日後）
            $displayLimitDay = new \DateTime($user->deleted_at);
            $displayLimitDay->modify("+ 10 days");
            
            // 現在日時
            $today = new \DateTime();
            
            // 現在日時が退会ユーザーを表示する日時以内の場合
            if ($today <= $displayLimitDay) {
                $withdrawUserIds[] = $user->id;
            }
        }
        
        return Matching::where('user_id', $withdrawUserIds)->where('user_id', $withdrawUserIds)->get();
    }
}
