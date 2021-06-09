<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Hobby;

class Profile extends Model
{
    protected $fillable = ['name', 'image', 'image_path', 'introduction', 'age', 'sex', 'birthday', 'residence','user_id', 'height', 'weight'];
    
    public function check_hobby($id)
    {
        // dd($id);
        $hobbies = $this->hobby()->where('profile_id', $id)->pluck('hobby');
        // $hobbies = $this->hobby()->where('profile_id', $id)->get();
        $answer ="";
        $count = count($hobbies);
        $i = 1;
        foreach($hobbies as $hobby){
            $answer .= $hobby;
            $i++;
            if($i <= $count){
        		$answer .= ','; // 最後の要素ではないとき
        	}
        }
        
        return $answer;
    }
    public function hobby()
    {
        return $this->hasMany('App\Hobby');
    }
    public function favorite_profile()
    {
        return $this->hasMany('App\Favorite');
    }
    public function birthYear($id)
    {
        // dump($id);
        $birth = $this->where('id', $id)->value('birthday');
        // dd($birth);
        return $birth;
    }
     public function matching()
    {
        return $this->hasMany('App\Matching');
    }
    public static function getmatchList($data, $user_id)
    {
        $blocked = Block::where('blocked_user_id', $user_id)->pluck('blocking_user_id');
        $blocking = Block::where('blocking_user_id', $user_id)->pluck('blocked_user_id');
        $hobby = "";
        $gender = Profile::where('user_id', $user_id)->value('sex');
        
        if($gender == 0)
        {
            $gender = 1;
        }else{
            $gender = 0;
        }
        
        $deleted_user_id = User::wherenotnull('deleted_at')->pluck('id');
            
        $matchList = Profile::where ('sex', $gender)->wherenotin ('id', $blocking)->wherenotin ('id', $deleted_user_id);
            
        if($data){
            if(!empty($data['hobby'])){
                foreach($data['hobby'] as $hobby){
                    $userHobby = Hobby::where('hobby', $hobby)->value('profile_id');
                    $matchList = $matchList->where('id', $userHobby);
                }
            }    
            if($data['residence'] != "NULL"){
                
                $matchList = $matchList-> where('residence', $data['residence']);
                // dump($matchList);
            }
            if($data['height'] != ""){
                $matchList = $matchList-> where ('height', '>=', $data['height']);
            }
            if($data['weight'] != "NULL"){
                $matchList = $matchList-> where ('weight', $data['weight']);
                // dump($matchList);
            }
        }
        return $matchList->get();
             
    }
    
}
