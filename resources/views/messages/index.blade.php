@extends('layouts.app')
 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div>
                <img src="{{ Storage::url($profile->image_path) }}" alt="image" style="width: 25vw; height: auto;"/>
            </div>
            <div class="">
                <h3>{{ $profile->name }}</h3>
            </div>
        </div>
    {{--  チャットルーム  --}}
        <div id="room" class="col-md-6">
            @foreach($messages as $key => $message)
                {{--   送信したメッセージ  --}}
                @if($message->user_id == \Illuminate\Support\Facades\Auth::id())
                    <div class="right" style="text-align: right">
                        <h3>{{$message->text}}</h3>
                    </div>
                @endif
     
                {{--   受信したメッセージ  --}}
                @if($message->receive_user_id == \Illuminate\Support\Facades\Auth::id())
                    <div class="receive_user_id" style="text-align: left">
                        <h3>{{$message->text}}</h3>
                    </div>
                @endif
            @endforeach
     
            <form method="POST" action="/messages/">
                @csrf
                <input type="hidden" name="room_id" value="{{ $matchingId }}">
                <input type="hidden" name="receive_user_id" value="{{ $profile->user_id }}">
                <div class="message">
                    <textarea name="text" class="message_text"></textarea>
                    <div>
                        <button type="submit" id="btn_send">送信</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <input type="hidden" name="send" value="{{$param['send']}}">
    <input type="hidden" name="recieve" value="{{$param['recieve']}}">
    <input type="hidden" name="login" value="{{\Illuminate\Support\Facades\Auth::id()}}">
 
</div>
 
@endsection
<!--@section('script')-->
<!--    <script type="text/javascript">-->
 
<!--       //ログを有効にする-->
<!--       Pusher.logToConsole = true;-->
 
<!--       var pusher = new Pusher('[YOUR-APP-KEY]', {-->
<!--           cluster  : '[YOUR-CLUSTER]',-->
<!--           encrypted: true-->
<!--       });-->
 
<!--       //購読するチャンネルを指定-->
<!--       var pusherChannel = pusher.subscribe('chat');-->
 
<!--       //イベントを受信したら、下記処理-->
<!--       pusherChannel.bind('chat_event', function(data) {-->
 
<!--           let appendText;-->
<!--           let login = $('input[name="login"]').val();-->
 
<!--           if(data.send === login){-->
<!--               appendText = '<div class="send" style="text-align:right"><p>' + data.message + '</p></div> ';-->
<!--           }else if(data.recieve === login){-->
<!--               appendText = '<div class="recieve" style="text-align:left"><p>' + data.message + '</p></div> ';-->
<!--           }else{-->
<!--               return false;-->
<!--           }-->
 
<!--           // メッセージを表示-->
<!--           $("#room").append(appendText);-->
 
<!--           if(data.recieve === login){-->
<!--               // ブラウザへプッシュ通知-->
<!--               Push.create("新着メッセージ",-->
<!--                   {-->
<!--                       body: data.message,-->
<!--                       timeout: 8000,-->
<!--                       onClick: function () {-->
<!--                           window.focus();-->
<!--                           this.close();-->
<!--                       }-->
<!--                   })-->
 
<!--           }-->
 
 
<!--       });-->
 
 
<!--        $.ajaxSetup({-->
<!--            headers : {-->
<!--                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),-->
<!--            }});-->
 
 
<!--        // メッセージ送信-->
<!--        $('#btn_send').on('click' , function(){-->
<!--            $.ajax({-->
<!--                type : 'POST',-->
<!--                url : '/chat/send',-->
<!--                data : {-->
<!--                    message : $('textarea[name="message"]').val(),-->
<!--                    send : $('input[name="send"]').val(),-->
<!--                    recieve : $('input[name="recieve"]').val(),-->
<!--                }-->
<!--            }).done(function(result){-->
<!--                $('textarea[name="message"]').val('');-->
<!--            }).fail(function(result){-->
 
<!--            });-->
<!--        });-->
<!--    </script>-->
 
<!--@endsection-->