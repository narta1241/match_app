@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="text-center col-sm-6">
                <div>
                    <img src="{{ Storage::url($profile->image_path) }}" alt="image" style="width: 100%; height: auto;"/>
                </div>
                <div>
                    <h3>{{ $profile->name." ". $profile->age."歳" }}</h3>
                </div>
                <div style='font-size: 14em; '>
                  <button type="button" id="favorite-btn-{{ $profile->user_id}}" class="btn {{ $profile->favorite_profile()->where('user_id', Auth::id())->where('profile_id', $profile->user_id)->first() ? "bg-primary" : "" }}" 
                          data-id="{{ $profile->user_id }}" onclick="favoriteStatus({{ $profile->user_id }})"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                          <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/></svg>
                  </button>
                </div>
            </div>
            <div class="text-center col-sm-6">
                 <table class="table table-bordered">
                      <tr>
                        <th>自己紹介文</th>
                        <td class="text-center">{{ $profile->introduction }}</td>
                      </tr>
                      <tr>
                        <th>居住地</th>
                        <td class="text-center">{{ $profile->residence }}</td>
                      </tr>
                      <tr>
                        <th>身長</th>
                        <td class="text-center">{{ $profile->height }}</td>
                      </tr>
                      <tr>
                        <th>体型</th>
                        <td class="text-center">{{ $profile->weight }}</td>
                      </tr>
                      <tr>
                        <th>趣味</th>
                        <td class="text-center">{{ $profile->check_hobby($profile->id) }}</td>
                      </tr>
                    </table>
            </div>
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