@extends('layouts.app')

@section('content')
        <div class="container">
            <p>あなたがブロックしたユーザー</p>
            <div class="text-center">
                @foreach($users as $user)
                    <div>
                        <a href={{ route('profiles.show', $user->blocked_user_id) }}><img src="{{ Storage::url($user->profile->image_path) }}" alt="image" style="width: 25vw; height: auto;"/></a>
                    </div>
                    <div>
                        <h3>{{ $user->profile->name }}</h3>
                        <form action="/blocks/{{ $user->blocked_user_id }}" method="POST" onsubmit="if(confirm('このユーザーのブロックを解除してよろしいですか？')) { return true } else {return false };">
                            @csrf
                            @method('delete')
                            <input type="hidden" value="{{ $user->blocked_user_id }}" name='blocked_user_id'>
                            <button type="submit" class="btn btn-danger">ブロック</button>
                        </form>
                        
                        
                    </form>
                    </div>
                @endforeach
            </div>
        </div>
@endsection
