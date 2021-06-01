@extends('layouts.app')
 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        </div>
    </div>
    <div>
        <img src="{{ Storage::url($profile->image_path) }}" alt="image" style="width: 25vw; height: auto;"/>
    </div>
    <div class="">
        <h3>{{ $profile->name }}</h3>
    </div>
    {{--  チャットルーム  --}}
    <div id="room">
        @foreach($messages as $key => $message)
            {{--   送信したメッセージ  --}}
            @if($message->send == \Illuminate\Support\Facades\Auth::id())
                <div class="send" style="text-align: right">
                    <p>{{$message->message}}</p>
                </div>
 
            @endif
 
            {{--   受信したメッセージ  --}}
            @if($message->recieve == \Illuminate\Support\Facades\Auth::id())
                <div class="recieve" style="text-align: left">
                    <p>{{$message->message}}</p>
                </div>
            @endif
        @endforeach
    </div>
 
    <form>
        <textarea name="message" style="width:100%"></textarea>
        <button type="button" id="btn_send" data-id="{{ $profile->id }}" onclick="pusherChat({{ $profile->id }})">送信</button>
    </form>
 
    <input type="hidden" name="user_id" value="{{$param['send']}}">
    <input type="hidden" name="receive_user_id" value="{{$param['recieve']}}">
    <input type="hidden" name="login" value="{{\Illuminate\Support\Facades\Auth::id()}}">
 
</div>
 
@endsection
<!--@section('script')-->
<!--    <script type="text/javascript">-->
<!--    function pusherChat(id){-->
<!--        // Enable pusher logging - don't include this in production-->
<!--        Pusher.logToConsole = true;-->
    
<!--        var pusher = new Pusher("{{ config('const.pusher.app_key') }}", {-->
<!--                cluster: "{{ config('const.pusher.cluster') }}"-->
<!--            });-->
    
<!--        var channel = pusher.subscribe('my-channel');-->
<!--            channel.bind('my-event', function(data) {-->
<!--                alert(JSON.stringify(data));-->
<!--            });-->
<!--    }-->
<!--    </script>-->
@section('script')
    <script type="text/javascript">
 
       //ログを有効にする
       Pusher.logToConsole = true;
 
       var pusher = new Pusher("{{ config('const.pusher.app_key') }}",
            cluster: "{{ config('const.pusher.cluster') }}",
            encrypted: true
       });
 
       //購読するチャンネルを指定
       var pusherChannel = pusher.subscribe('my-channel');
 
       //イベントを受信したら、下記処理
       pusherChannel.bind('my-event', function(data) {
 
           let appendText;
           let login = $('input[name="login"]').val();
 
           if(data.send === login){
               appendText = '<div class="send" style="text-align:right"><p>' + data.text + '</p></div> ';
           }else if(data.recieve === login){
               appendText = '<div class="recieve" style="text-align:left"><p>' + data.text + '</p></div> ';
           }else{
               return false;
           }
 
           // メッセージを表示
           $("#room").append(appendText);
 
           if(data.recieve === login){
               // ブラウザへプッシュ通知
               Push.create("新着メッセージ",
                   {
                       body: data.text,
                       timeout: 8000,
                       onClick: function () {
                           window.focus();
                           this.close();
                       }
                   })
 
           }
 
 
       });
 
 
        $.ajaxSetup({
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),
            }});
 
 
        // メッセージ送信
        $('#btn_send').on('click' , function(){
            $.ajax({
                type : 'POST',
                url : '{{ route('messages.store') }}',
                data : {
                    text : $('textarea[name="text"]').val(),
                    user_id : $('input[name="user_id"]').val(),
                    receive_user_id : $('input[name="receive_user_id"]').val(),
                }
            }).done(function(result){
                $('textarea[name="text"]').val('');
            }).fail(function(result){
 
            });
        });
    </script>
 
@endsection