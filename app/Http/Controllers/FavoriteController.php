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
        $blocking = Block::where('blocking_user_id', Auth::id())->pluck('blocked_user_id');
        switch($pattern){
            case 'favoritting':
                $favorites = Favorite::where('user_id', Auth::id())->wherenotin ('profile_id', $blocking)->get();
                return view('favorites.favoritting', compact('favorites'));
            case 'favorited':
                $favorites = Favorite::where('profile_id', Auth::id())->wherenotin ('user_id', $blocking)->get();
                // dd($favorites);
                return view('favorites.favorited', compact('favorites'));
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
