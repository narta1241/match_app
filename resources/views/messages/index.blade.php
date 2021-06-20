@extends('layouts.app')
 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 text-center">
            <div>
                <img src="data:image/png;base64,{{$profile->image}}" alt="image" style="width: 25vw; height: auto;"/>
            </div>
            <div class="pt-4">
                <h2>{{ $profile->name }}</h2>
            </div>
        </div>
    {{--  チャットルーム  --}}
    <div class="col-md-6">
        
        <div id="room">
            @foreach($messages as $key => $message)
                <div class="sent_msg">
                    @if($profile->sex == 1)
                    <div class="sent_withd_msgM">
                    @else
                    <div class="sent_withd_msgW">
                    @endif
                    {{--   送信したメッセージ  --}}
                    @if($message->user_id == \Illuminate\Support\Facades\Auth::id())
                        <div class="user_id" style="text-align: right">
                            <h3>{{$message->text}}</h3>
                        </div>
                    @endif
                    </div>
                </div>
                <div class="received_msg">
                    @if($profile->sex == 0)
                    <div class="received_withd_msgM">
                    @else
                    <div class="received_withd_msgW">
                    @endif
                        {{--   受信したメッセージ  --}}
                        @if($message->receive_user_id == \Illuminate\Support\Facades\Auth::id())
                            @if($billing == 1)
                            <div class="receive_user_id" style="text-align: left">
                                
                                <h3>{{$message->text}}</h3>
                            </div>
                            @else
                            <div class="receive_user_id blur" style="text-align: left">
                                
                                <h3>{{ substr(bin2hex(random_bytes(strlen($message->text))), 0,strlen($message->text)) }}</h3>
                            </div>
                            @endif
                            
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div>
            @if($billing == 1)
			<!--<div class="send-message">-->
			<!--  <form action="" method="">-->
			<!--   <textarea  id="text" name="text" cols="10" rows="1" class="form-control" placeholder="メッセージを入力"> </textarea>-->
			<!--    <ul class="list-inline"> -->
			<!--	  <li> <button type="button" id="btn_send" ><i class="fas fa-paper-plane"></i></button> </li>-->
			<!--	</ul>-->
			<!--  </form>-->
			<!--</div>-->
				   
	        <form action="" method="">
			    <div class="input-group">
                    <textarea  id="text" name="text" cols="10" rows="1" class="form-control" placeholder="メッセージを入力"></textarea>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary" id="btn_send">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </span>
                </div>
            </form>
            @else
                <span class="user_id text-danger rounded-lg" style="font-size:24px;background-color:skyblue;">
                   ※有料会員のみメッセージの送受信が可能です※
                </span>
                 
                <div class="btn billingBtn"><a class="text-white" id="modal-open" href="javascript:void(0)">有料会員になる</a></div>
            @endif
                <input type="hidden" id="room_id" name="room_id" value="{{ $matchingId }}">
                <input type="hidden" id="user_id" name="user_id" value="{{ $param['send'] }}">
                <input type="hidden" id="receive_user_id" name="receive_user_id" value="{{$param['recieve']}}">
 
                <input type="hidden" id="login" name="login" value="{{\Illuminate\Support\Facades\Auth::id()}}">
                
				<div class="panel-footer">
			    
			    
        </div>
        
    </div>
 
</div>
@endsection
@include('layouts.partials.modal_window')

@section('javascript')
   
    <script type="text/javascript">
  
     $(function () {
        
        $.ajaxSetup({
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),
            }});
            
        $('button').click(function () {
            $.ajax({
                type : 'POST',
                url : '{{ route('messages.store') }}',
                data : {
                    room_id : $('input[name="room_id"]').val(),
                    text : $('textarea[name="text"]').val(),
                    user_id : $('input[name="user_id"]').val(),
                    receive_user_id : $('input[name="receive_user_id"]').val(),
                },
                dataType : "json",
                success: function(result){
                    $('textarea[name="text"]').val('');
                    <!--console.log(result);-->
                },
                error: function(result){
                    <!--debugger;-->
                    console.log(result);
                }
            });
        });
    });
  
    </script>
@endsection
@section('script')
    
    <script type="text/javascript">
      
       //ログを有効にする
       Pusher.logToConsole = true;
       
       var pusher = new Pusher("{{ config('const.pusher.app_key') }}", {
            cluster: "{{ config('const.pusher.cluster') }}",
            encrypted: true
       });
       
       //購読するチャンネルを指定
       var pusherChannel = pusher.subscribe("chat");
        
       //イベントを受信したら、下記処理
       pusherChannel.bind('chat_event', function(data) {
           console.log(data);
 
            let appendText;
            let login = $('input[name="login"]').val();
            let billing = "{{ $billing }}";
            let sex = "{{ $profile->sex }}";
           console.log(billing);
           if(data.user_id === login){
               if(sex== 1){
                    appendText ='<div class="sent_msg"><div class="sent_withd_msgM">';
                }else{
                    appendText ='<div class="sent_msg"><div class="sent_withd_msgW">';
                }
               appendText += '<div class="user_id" style="text-align:right"><h3>' + data.text + '</h3></div> ';
           }else if(data.receive_user_id === login){
                if(sex== 0){
                    appendText ='<div class="received_msg"><div class="received_withd_msgM">';
                }else{
                    appendText ='<div class="received_msg"><div class="received_withd_msgW">';
                }
                    if(billing== 1){
                        appendText += '<div class="receive_user_id" style="text-align:left"><h3>' + data.text + '</h3></div> ';
                    }
                    else{
                        let length = data.text.length;
                        let faketext = Math.random().toString(36).slice(length);
                        console.log(faketext);
                        appendText += '<div class="receive_user_id blur" style="text-align:left"><h3>' + faketext + '</h3></div> ';
                    }
           }else{
               return false;
           }

            console.log(appendText);
           // メッセージを表示
           $("#room").append(appendText);
 
           if (data.receive_user_id === login) {
                // ブラウザへプッシュ通知
                console.log(
                    Push.create("新着メッセージ",
                       {
                           body: data.text,
                           timeout: 8000,
                           onClick: function () {
                               window.focus();
                               this.close();
                           }
                       }
                    )
                );
           }
       });
 
    </script>
   
@endsection

