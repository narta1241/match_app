@extends('layouts.app')

@section('content')
<div class ="text-center container-fluid">
    <div class = "row">
        @foreach($matchList as $user)
        <div class = "col-4">
            <div>
                <a href={{ route('profiles.show', $user->id) }}><img src="{{ Storage::url($user->image_path) }}" alt="image" style="width: 50%; height: auto;"/></a>
            </div>
            <div>
                <h3>{{ $user->name." ".$user->age }}</h3>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

