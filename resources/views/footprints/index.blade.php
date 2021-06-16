@extends('layouts.app')

@section('content')
        <!--<div class="container">-->
            <div class="align-items-center my-3 underlineFoot">
                <h3>あなたのプロフィールを見にきた人</h3>
            </div>
            <div id="list" class="text-center">
                @foreach($footprints as $footprint)
                    <div class="ml-4">
                        <a href={{ route('profiles.show', $footprint->profile->id) }}><img src="data:image/png;base64,{{$footprint->image}}" alt="image" style="width: 400px; height: 350px;"/></a>
                        <h3>{{ $footprint->profile->name." ". $footprint->profile->age."歳　".$footprint->foottime($footprint->profile->user_id)."日前" }}</h3>
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