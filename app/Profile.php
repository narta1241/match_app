<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    
    
}
