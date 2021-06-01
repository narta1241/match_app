@extends('layouts.app')

@section('content')
    <!--<a href="{{ route('favorites.index', ['pattern' => 'favorited']) }}"> いいねされた</a>-->
    <!--<a href="{{ route('favorites.index', ['pattern' => 'favoritting']) }}"> いいねした</a>-->
        <div class="container">
            <div class="row">
                <div class="text-center col-sm-8 col-md-offset-2">
                        <h3>マッチングユーザー一覧</h3>
                @foreach($matches as $match)
                    <div>
                        <img src="{{ Storage::url($match->profile->image_path) }}" alt="image" style="width: 25vw; height: auto;"/>
                    </div>
                    <div class="">
                        <h3>{{ $match->profile->name." ". $match->profile->age."歳" }}</h3>
                    </div>
                    <div class="">
                        <a href={{ route('messages.index', $match->room($match->receive_user_id, $match->profile->user_id)) }}><button type="button" class="btn btn-primary">Chat</button></a>
                        <form method="post" action="/blocks/">
                            @csrf
                            <input type ="hidden" name='blocked_user_id' value={{$match->profile->id}}>
                            <button type="submit" class="btn btn-danger" onclick="return check()">ブロック</button>
                        </form>
                    </div>
                @endforeach
                @if($losts)
                    @foreach($losts as $lost)
                        <div>
                            <img src="/img/退会.jpeg" alt="image" style="width: 25vw; height: auto;"/>
                        </div>
                        <div class="">
                            <h3>{{ $lost->profile->name." ". $lost->profile->age."歳" }}</h3>
                            <p class="text-danger">このユーザーは退会済みです</p>
                        </div>
                    @endforeach
                @endif
                </div>
            </div>
        </div>
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