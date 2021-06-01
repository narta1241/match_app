<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Matching;
use App\User;
use App\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pattern)
    {
        $user_id = User::wherenotnull('deleted_at')->pluck('id');
        // dump($user_id);
        $blocking = Block::where('blocking_user_id', Auth::id())->pluck('blocked_user_id');
        $delete_days = User::wherenotnull('deleted_at')->pluck('deleted_at');
        $lost ="";
        $losts = Matching::where('receive_user_id', Auth::id())->where ('user_id', $user_id)->get();
        foreach($delete_days as $delete_day){
            $deleted_day = strtotime($delete_day);
            $today = date('Y-m-d');
            $today = strtotime($today);
            
            $other_day = (($today - $deleted_day) / (60 * 60 * 24));
            
            if($other_day < 10){
                $lost .= User::where ('deleted_at', $delete_day)->value('id');
            }
        }
        
        $losts = $losts->wherenotin('$id', $lost);
        
        switch($pattern){
            case 'favoritting':
                $favorites = Favorite::where('user_id', Auth::id())->wherenotin ('profile_id', $blocking)->wherenotin ('profile_id', $user_id)->get();
                return view('favorites.favoritting', compact('favorites', 'losts'));
            case 'favorited':
                $favorites = Favorite::where('profile_id', Auth::id())->wherenotin ('user_id', $blocking)->wherenotin ('profile_id', $user_id)->get();
                // dd($favorites);
                return view('favorites.favorited', compact('favorites', 'losts'));
            default:
                dd($request);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // お気に入りを取得する
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('profile_id', $request->input('profile_id'))
            ->first();
        // 既にお気に入りされている場合
        if ($favorite) {
            $favorite->delete();

            return response()->json([
                'result' => 'deleted'
            ]);
        // お気に入りされていない場合
        } else {
            Favorite::create([
                'profile_id' => $request->input('profile_id'),
                'user_id' => Auth::id(),
            ]);
            $mailSendUser = User::where('id' , $request->input('profile_id'))->first();
            $to = $mailSendUser->email;
            $mail = app()->make('App\Http\Controllers\MailingController');
            $mail->favoriteMail($to, Auth::user()->name);
            Matching::match(Auth::id(), $request->input('profile_id'));
            
             return response()->json([
                'result' => 'created'
             ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        //
    }
}
