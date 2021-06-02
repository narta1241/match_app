<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use App\Hobby;
use App\Block;
use App\FootPrint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = User::where('id', Auth::id())->first();
        // if (!empty($_GET['search'])) {
        $blocked = Block::where('blocked_user_id', Auth::id())->pluck('blocking_user_id');
        $blocking = Block::where('blocking_user_id', Auth::id())->pluck('blocked_user_id');
        // dd($blocking);
        
            $gender = Profile::where('user_id', Auth::id())->value('sex');
            if($gender == 0)
            {
                $gender = 1;
            }else{
                $gender = 0;
            }
            // dd($gender);
            $user_id = User::wherenotnull('deleted_at')->pluck('id');
            $matchList = Profile::where ('sex', $gender)->wherenotin ('id', $blocking)->wherenotin ('id', $user_id)->get();
            // dd($matchList);
        // } else {
            
        // }
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
        $birthday = $request->input('year'). $request->input('month'). $request->input('day');
        // $request->validate([       // <-- ここがバリデーション部分
        //     'title' => "required|unique:series,title,$request->title",
        //     'current_volume' => 'required',
        // ]);

        $upload_image = $request->file('image');
	    
		if($upload_image) {
			//アップロードされた画像を保存する
			$path = $upload_image->store('uploads',"public");
        // dd($path);
			//画像の保存に成功したらDBに記録する
			if($path){
                Profile::create([
                    'name' => $request->input('name'),
                    'image' => $upload_image->getClientOriginalName(),
                    "image_path" => $path,
                    'introduction' => $request->input('introduction'),
                    'age' => $request->input('age'),
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
    public function edit(Profile $profile)
    {
        $hob = Hobby::where('profile_id', $profile->user_id)->pluck('hobby');
        $profile = Profile::where('user_id', $profile->user_id)->first();
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
        if($request->file('image')){
            $upload_image = $request->file('image');
            // dd($upload_image);
			//アップロードされた画像を保存する
			$path = $upload_image->store('uploads',"public");
            // dump($path);
			if($path){
                $profile->image = $upload_image->getClientOriginalName();
                $profile->image_path = $path;
			}
        }
            $profile->name = $request->input('name');
            $profile->introduction = $request->input('introduction');
            $profile->age = $request->input('age');
            $profile->sex = $request->input('sex');
            $profile->birthday = $birthday;
            $profile->residence = $request->input('residence');
            $profile->user_id = Auth::id();
            $profile->height = $request->input('height');
            $profile->weight = $request->input('weight');
			$hobbies = Hobby::where('profile_id', Auth::id())->get();
		
            $choice = $request->input('hobby');
            // dd($choice);
            foreach ($hobbies as $hobby) {
                foreach ($choice as $hob) {
                    // dump($hobby->hobby);
                    // dump($hob);
                    // dump($hob == $hobby->hobby);
                    if(!($hob == $hobby->hobby)){
                        $hobby = new hobby();
                        $hobby->profile_id = Auth::id();
                        $hobby->hobby = $hob;
                        // $hobby->genre = "";
                    }
                }
            }
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
        $today = date('Y-m-d');
        Auth::logout();
        User::where('id', $id)->update(['deleted_at' => $today]);
        return redirect()->route('profiles.index');
    }
}
