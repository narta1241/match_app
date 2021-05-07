@extends('layouts.app')

@section('content')
        <div class="container">
            <p>あなたのプロフィールを見にきた人</p>
            <div class="text-center">
                @foreach($users as $user)
                    <div>
                        <a href={{ route('profiles.show', $user->id) }}><img src="{{ Storage::url($user->image_path) }}" alt="image" style="width: 25vw; height: auto;"/></a>
                    </div>
                    <div>
                        <h3>{{ $user->name." ". $user->age."歳　".$user->foottime($user->user_id)."日前" }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
@endsection