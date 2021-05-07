<?php

namespace App\Http\Controllers;

use App\Message;
use App\Matching;
use App\Profile;
use App\User;
use App\Mail\SampleNotification;
use App\Events\ChatMessageRecieved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($matchingId)
    {
        // dd($recieve);
        $recieve_id = Matching::where('id', $matchingId)->where('user_id', Auth::id())->value('receive_user_id');
        // チャットの画面
        $loginId = Auth::id();
        
        // 送信 / 受信のメッセージを取得する
        $query = Message::where('user_id' , $loginId)->where('receive_user_id' , $recieve_id);
        $query->orWhere(function($query) use($loginId , $recieve_id){
            $query->where('user_id' , $recieve_id);
            $query->where('receive_user_id' , $loginId);
        });

        $messages = $query->get();
 
        $param = [
          'send' => $loginId,
          'recieve' => $recieve_id,
        ];
        // dd($messages);
        
        $profile = Profile::where('user_id', $recieve_id)->first();
        
        // dd($messages);
        return view('messages.index', compact('param', 'messages', 'profile', 'matchingId'));
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
    /**
     * メッセージの保存をする
     */
    public function store(Request $request)
    {
        $room_id = $request->input('room_id');
        // if(!$room_id){
        //     $room_id = 100;
        // }
        Message::create([
            'room_id' => $room_id,
            'user_id' => Auth::id(),
            "receive_user_id" => $request->input('receive_user_id'),
            'text' => $request->input('text'),
            'read_flg' => 0,
        ]);
        
        $mailSendUser = User::where('id' , $request->input('receive_user_id'))->first();
        $to = $mailSendUser->email;
        $mail = app()->make('App\Http\Controllers\MailingController');
        $mail->sendMail($to, $request->input('text'), Auth::user()->name);
        $recieve = $request->input('receive_user_id');
        
        return redirect()->route('messages.index', ['room' => $request->input('room_id')]);
       
        // リクエストパラメータ取得
        // $insertParam = [
        //     'send' => $request->input('send'),
        //     'recieve' => $request->input('recieve'),
        //     'message' => $request->input('message'),
        // ];
 
 
        // // メッセージデータ保存
        // try{
        //     Message::insert($insertParam);
        // }catch (\Exception $e){
        //     return false;
 
        // }
        // // イベント発火
        // event(new ChatMessageRecieved($request->all()));
 
        // メール送信
        // $mailSendUser = User::where('id' , $request->input('recieve'))->first();
        // $to = $mailSendUser->email;
        // $mail = app()->make('App\Http\Controllers\MailingController');
        // $mail->sendMail($to);
        
        // return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
    }
 
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function edit(Messages $messages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Messages $messages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Messages $messages)
    {
        //
    }
}
