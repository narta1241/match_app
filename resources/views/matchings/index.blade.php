@extends('layouts.app')

@section('content')
        <!--<div class="container">-->
            <div class="align-items-center my-3 underlineMatch">
            <h3>マッチングしたお相手</h3>
            </div>
                <div id="list" class="text-center">
                @foreach($matches as $match)
                    <div class="ml-4">
                        <img src="{{ Storage::url($match->profile->image_path) }}" alt="image" style="width: 400px; height: 350px;"/>
                    
                        <h3>{{ $match->profile->name." ". $match->profile->age."歳" }}</h3>
                    
                        <div>
                            <div class="btn btn-chat"><a class="text-white" href="{{ route('messages.index', $match->room($match->receive_user_id, $match->profile->user_id)) }}" style="font-size: 20px;">Chat</a></div>
                            <div class="btn btn-danger ml-4"><a class="text-white" onclick="return check()" href="{{ route('blocks.store', $match->profile->id) }}" style="font-size: 20px;">ブロック</a></div>
                        </div>
                            
    
                        <!--<form method="post" action="/blocks/">-->
                        <!--    @csrf-->
                        <!--    <input type ="hidden" name='blocked_user_id' value={{$match->profile->id}}>-->
                        <!--    <button type="submit" class="btn btn-danger" onclick="return check()">ブロック</button>-->
                        <!--</form>-->
                    </div>
                @endforeach
                @if($losts)
                    @foreach($losts as $lost)
                        <div>
                            <img src="/img/退会.jpeg" alt="image" style="width: 400px; height: 350px;"/>
                       
                            <h3>{{ $lost->profile->name." ". $lost->profile->age."歳" }}</h3>
                            <p class="text-danger">このユーザーは退会済みです</p>
                        </div>
                    @endforeach
                @endif
                </div>
        <!--</div>-->
@endsection

<script type="text/javascript"> 
function check(){

	if(window.confirm('このユーザーをブロックしてよろしいですか？')){ // 確認ダイアログを表示
		return true; // 「OK」時は送信を実行
	}
	else{
	    return false;
	}

}
</script>