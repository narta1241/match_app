<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Block;

class Favorite extends Model
{
    protected $fillable = ['profile_id', 'user_id'];
    
    public function profile()
    {
        return $this->belongsTo('App\Profile', 'user_id', 'user_id');
    }
     public function profile_favorited()
    {
        return $this->belongsTo('App\Profile', 'profile_id', 'user_id');
    }
    public function user_ing()
    {
        return $this->belongsTo('App\User', 'profile_id');
    }
    public function user_ed()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
   
      /**
     * ログインユーザーIDに紐づくいいねしたデータを取得する
     * （退会ユーザーを除く）
     * @param $loginUserId ログインユーザーID
     * @return array 
     */
    public static function getByFavorittingUserId($loginUserId)
    {
        $favorittingModel =Favorite::where('profile_id', $loginUserId);
        // dd($favorittingModel);
        
        $withdrawUserIds = User::wherenotnull('deleted_at')->pluck('id');
        if ($withdrawUserIds) {
            $favorittingModel->wherenotin('user_id', $withdrawUserIds);
        }
        
         //ブロックユーザーを含めない
        $blocked = Block::where('blocked_user_id', $loginUserId)->pluck('blocking_user_id');
        $blocking = Block::where('blocking_user_id', $loginUserId)->pluck('blocked_user_id');
        if($blocked){
            $favorittingModel = $favorittingModel->wherenotin ('id', $blocked);
        }   
            
        if($blocking){
            $favorittingModel = $favorittingModel->wherenotin ('id', $blocking);
        }   
        return $favorittingModel->get();
    }
      /**
     * ログインユーザーIDに紐づくいいねされたデータを取得する
     * （退会ユーザーを除く）
     * @param $loginUserId ログインユーザーID
     * @return array 
     */
    public static function getByFavoritedUserId($loginUserId)
    {
        $favoritedModel =Favorite::where('user_id', $loginUserId);
        
        $withdrawUserIds = User::wherenotnull('deleted_at')->pluck('id');
        if ($withdrawUserIds) {
            $favoritedModel->wherenotin('profile_id', $withdrawUserIds);
        }
        
          //ブロックユーザーを含めない
        $blocked = Block::where('blocked_user_id', $loginUserId)->pluck('blocking_user_id');
        $blocking = Block::where('blocking_user_id', $loginUserId)->pluck('blocked_user_id');
        if($blocked){
            $favoritedModel = $favoritedModel->wherenotin ('id', $blocked);
        }   
            
        if($blocking){
            $favoritedModel = $favoritedModel->wherenotin ('id', $blocking);
        }   
        
        return $favoritedModel->get();
    }
    
    /**
     * ログインユーザーIDに紐づく退会ユーザーとのマッチングデータを取得する
     * （アクティブユーザーを除く）
     * @param $loginUserId ログインユーザーID
     * 
     */
    public static function getWithdrawByfavorittingUserId($loginUserId)
    {
        $Favorites = Favorite::where('profile_id', $loginUserId)->get();
        $withdrawUserIds = [];
        foreach ($Favorites as $favorite) {
            $user = $favorite->user_ed;
            
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
        
        return Favorite::where('user_id', $withdrawUserIds)->get();
    }
    /**
     * ログインユーザーIDに紐づく退会ユーザーとのマッチングデータを取得する
     * （アクティブユーザーを除く）
     * @param $loginUserId ログインユーザーID
     * 
     */
    public static function getWithdrawByfavoritedUserId($loginUserId)
    {
        $Favorites = Favorite::where('user_id', $loginUserId)->get();
                
        $withdrawUserIds = [];
        foreach ($Favorites as $favorite) {
            $user = $favorite->user_ing;
            // dd($user);
            
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
        
        return Favorite::wherein('profile_id', $withdrawUserIds)->get();
    }
}
