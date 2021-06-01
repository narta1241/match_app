@extends('layouts.app')

@section('content')
    <a href="{{ route('favorites.index', ['pattern' => 'favorited']) }}"> いいねされた</a>
    <a href="{{ route('favorites.index', ['pattern' => 'favoritting']) }}"> いいねした</a>
        <div class="container">
            <div class="row">
                <div class="text-center col-sm-12">
                    <p>いいねされた</p>
                @foreach($favorites as $favorite)
                    <div>
                        <a href={{ route('profiles.show', $favorite->profile_favorited->id) }}><img src="{{ Storage::url($favorite->profile_favorited['image_path']) }}" alt="image" style="width: 25vw; height: auto;"/></a>
                    </div>
                    <div class="">
                        <h3>{{ $favorite->profile_favorited->name." ". $favorite->profile_favorited->age."歳" }}</h3>
                    </div>
                    <div style='font-size: 14em; '>
                      <button type="button" id="favorite-btn-{{ $favorite->user_id}}" class="btn {{ $favorite->where('user_id', Auth::id())->where('profile_id', $favorite->user_id)->first() ? "bg-primary" : ""}}" 
                              data-id="{{ $favorite->user_id }}" onclick="favoriteStatus({{ $favorite->user_id }})"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                              <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/></svg>
                      </button>
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
@section('javascript')
    <script>
       function favoriteStatus(id) {
            const profileId = id;
            $.ajax({
                type: "POST",
                url: "{{ route('favorites.store') }}",
                data: {
                    "_token" : "{{ csrf_token() }}",
                    "profile_id" : profileId,
                },
                dataType : "json",
                success: function(data) {

                    if (data.result === 'created') {
                             $('#favorite-btn-' + profileId).addClass('bg-primary');
                        } else {
                             $('#favorite-btn-' + profileId).removeClass('bg-primary');
                        }
                    },
                error: function(err) {
                    alert('error');
                }
            });
                // console.log($(err));
                <!--console.log($(":input"));-->
           // console.log(data.result);
        }
    </script>