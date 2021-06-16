<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use App\Hobby;
use App\Block;
use App\FootPrint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matchList = Profile::getmatchList($_GET, Auth::id());
           
        return view('profiles.index', compact('matchList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([       // <-- ここがバリデーション部分
            'name' => "required|max:15",
            'image' => "required",
            'introduction' => 'required|max:500',
            'sex' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'hobby' => 'required',
            'height' => 'required|numeric',
        ]);
        // dd($request);
        $birthday = $request->input('year'). $request->input('month'). $request->input('day');
        // $request->validate([       // <-- ここがバリデーション部分
        //     'title' => "required|unique:series,title,$request->title",
        //     'current_volume' => 'required',
        // ]);
        $now = date("Ymd");
        $upload_image = $request->file('image');
	    
		if($upload_image) {
	
			//画像の保存に成功したらDBに記録する
                Profile::create([
                    'name' => $request->input('name'),
                    'image' => base64_encode(file_get_contents($upload_image->getRealPath())),
                    "image_path" => "",
                    'introduction' => $request->input('introduction'),
                    'age' => floor(($now-$birthday)/10000),
                    'sex' => $request->input('sex'),
                    'birthday' => $birthday,
                    'residence' => $request->input('residence'),
                    'user_id' => Auth::id(),
                    'height' => $request->input('height'),
                    'weight' => $request->input('weight')
                ]);
                $choice = $request->input('hobby');
                foreach ($choice as $hob) {
                    $hobby = new Hobby();
                    $hobby->profile_id = Auth::id();
                    $hobby->hobby = $hob;
                    // $hobby->genre = "";
                    $hobby->save();
                }
		}
        
        return redirect()->route('profiles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        $stamp = FootPrint::where('footed_user_id', $profile->user_id)->where('footting_user_id', Auth::id())->first();
        if(!$stamp){
             FootPrint::create([
                'footed_user_id' => $profile->user_id,
                'footting_user_id' => Auth::id(),
           ]);
        }
        return view('profiles.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $hob = Hobby::where('profile_id', Auth::id())->pluck('hobby');
        $profile = Profile::where('user_id', Auth::id())->first();
        // dump($hob);
        $birthday = $profile->birthday;
        $y = substr($birthday, 0, 4);
        $m = substr($birthday, 4, 2);
        $d = substr($birthday, 6, 2);
        return view('profiles.edit', compact('profile', 'hob', 'y', 'm', 'd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $birthday = $request->input('year'). $request->input('month'). $request->input('day');
        // dd($birthday);
        $now = date("Ymd");
        $request->validate([       // <-- ここがバリデーション部分
            'name' => "required|max:15",
            'introduction' => 'required|max:500',
            'hobby' => 'required',
            'height' => 'required|numeric',
        ]);
        if($request->file('image')){
            $upload_image = $request->file('image');
            // dd($upload_image);
			//アップロードされた画像を保存する
			$path = $upload_image->store('uploads',"public");
            // dump($path);
			if($path){
                $profile->image = base64_encode(file_get_contents($upload_image->getRealPath()));
                $profile->image_path = $path;
			}
        }
            $profile->name = $request->input('name');
            $profile->introduction = $request->input('introduction');
            $profile->age = floor(($now-$birthday)/10000);
            $profile->sex = $request->input('sex');
            $profile->birthday = $birthday;
            $profile->residence = $request->input('residence');
            $profile->user_id = Auth::id();
            $profile->height = $request->input('height');
            $profile->weight = $request->input('weight');
            $choice = $request->input('hobby');
			$hobbies = Hobby::where('profile_id', Auth::id())->get();
		  //  dump($hobbies);
            foreach ($choice as $hob) {
                $hobby = $hobbies->where('hobby', $hob)->first();
                if(!$hobby){
                    $hobby = new hobby();
                    $hobby->profile_id = Auth::id();
                    $hobby->hobby = $hob;
                    // $hobby->genre = "";
                }
            }
            // dd($hobby);
            $hobby->save();
            $profile->save();
       return redirect()->route('profiles.index');
                
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
       //
    }
    public function withdrawal($id)
    {
        $user =Auth::user();
        // 有料会員のキャンセル
        \Stripe\Stripe::setApiKey('sk_test_51IieGhE9LwkIsOfen0F6eSO2VSmA6A2XNXQrujly8EhAQu2HmXgZNVurgO1KzjQKHKuyWbcQhEkuAkfbKp411bJ400CEHBVpgP');

        $user->subscription('main')->cancel();
        
        $today = date('Y-m-d');
        
        // ユーザーの削除
        User::where('id', $id)->update(['deleted_at' => $today]);
        
        Auth::logout();
        
        return redirect()->route('profiles.index');
    }
   
}
