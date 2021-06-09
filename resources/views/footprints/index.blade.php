@extends('layouts.app')

@section('content')
        <div class="container">
            <p>あなたのプロフィールを見にきた人</p>
            <div class="text-center">
                @foreach($footprints as $footprint)
                    <div>
                        <a href={{ route('profiles.show', $footprint->profile->id) }}><img src="{{ Storage::url($footprint->profile->image_path) }}" alt="image" style="width: 400px; height: 350px;"/></a>
                    </div>
                    <div>
                        <h3>{{ $footprint->profile->name." ". $footprint->profile->age."歳　".$footprint->foottime($footprint->profile->user_id)."日前" }}</h3>
                    </div>
                @endforeach
                @if($losts)
                    @foreach($losts as $lost)
                        <div>
                            <img src="/img/退会.jpeg" alt="image" style="width: 400px; height: 350px;"/>
                        </div>
                        <div class="">
                            <h3>{{ $lost->profile->name." ". $lost->profile->age."歳" }}</h3>
                            <p class="text-danger">このユーザーは退会済みです</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
@endsection