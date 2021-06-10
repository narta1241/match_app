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
        // dd($messages);
        $param = [
          'send' => $loginId,
          'recieve' => $recieve_id,
        ];
        // dd($messages);
        
        $profile = Profile::where('user_id', $recieve_id)->first();
        $billing = User::where('id', Auth::id())->value('billing');
        // dd($messages);
        return view('messages.index', compact('param', 'messages', 'profile', 'matchingId', 'billing'));
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
        //リクエストパラメータ取得
        $insertParam = [
            'room_id' => $request->input('room_id'),
            'user_id' => $request->input('user_id'),
            'receive_user_id' => $request->input('receive_user_id'),
            'text' => $request->input('text'),
        ];

        // メッセージデータ保存
        try{
            Message::insert($insertParam);
        }catch (\Exception $e){
           return response()->json([
                'result' => 'error'
            ]);
        }
        // イベント発火
        event(new ChatMessageRecieved($request->all()));
        
        // $mailSendUser = User::where('id' , $request->input('receive_user_id'))->first();
        // $to = $mailSendUser->email;
        // $mail = app()->make('App\Http\Controllers\MailingController');
        // $mail->sendMail($to, $request->input('text'), Auth::user()->name);
        
        // dd($insertParam);
        return response()->json([
                'result' => 'success'
            ]);
        // return redirect()->route('messages.index', ['room' => $room_id]);
        
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
    public function script()
    {
        return view('messages.script');
    }
}
