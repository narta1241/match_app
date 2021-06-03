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
    public function user()
    {
        return $this->belongsTo('App\User', 'footed_user_id');
    }
    
    /**
     * ログインユーザーIDに紐づく足跡データを取得する
     * （退会ユーザーを除く）
     * @param $loginUserId ログインユーザーID
     * @return array Matching
     */
    public static function getByLoginUserId($loginUserId)
    {
        $footModel = FootPrint::where('footed_user_id', $loginUserId);
        
        $withdrawUserIds = User::wherenotnull('deleted_at')->pluck('id');
        if ($withdrawUserIds) {
            $footModel->wherenotin('footed_user_id', $withdrawUserIds);
        }
        
        return $footModel->get();
    }
    /**
     * ログインユーザーIDに紐づく退会ユーザーとの足跡データを取得する
     * （アクティブユーザーを除く）
     * @param $loginUserId ログインユーザーID
     * 
     */
    public static function getWithdrawByLoginUserId($loginUserId)
    {
        $footPrints = FootPrint::where('footed_user_id', $loginUserId)->get();
        // dd($footprints);
        $withdrawUserIds = [];
        foreach ($footPrints as $footPrint) {
            $user = $footPrint->user;
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
        
        return FootPrint::where('footed_user_id', $withdrawUserIds)->get();
    }
    /**
     * 足跡をつけたユーザーIDに紐づくデータを取得する
     *
     * @param $loginUserId ログインユーザーID
     * 
     */
    public function foottime($foottingUserId)
    {
        $usertime = $this->where('footting_user_id', $foottingUserId)->value('updated_at');
        $usertime = strtotime($usertime);
        
        $today = date('Y-m-d');
        $today = strtotime($today);
        
        return  intval(($today - $usertime) / (60 * 60 * 24));
    }
}
