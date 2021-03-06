@extends('layouts.app')

@section('content')
    <div class="mr-4 searchBtn">
        <a href="{{ route('search.index') }}" class='btn sBtnContents'>絞り込み検索</a>
    </div>
    
<div class ="text-center container-fluid">
    <div class = "row">
        @foreach($matchList as $user)
        <div id = "list" class = "col-4 mt-4">
            <div>
                <a href={{ route('profiles.show', $user->id) }}><img src="data:image/png;base64,{{$user->image}}" alt="image" style="width: 250px; height: 200px;"/></a>
                <h3>{{ $user->name." ".$user->age."歳" }}</h3>
            </div>
        </div>
        @endforeach
    </div>
       
</div>
@endsection

