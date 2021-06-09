@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('プロフィール検索') }}</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('profiles.index') }}">
                        @csrf
                        <div class="">
                    	    <label>居住地</label>
                                <select type="text" class="form-control @error('residence') is-invalid @enderror" name="residence" required autocomplete="residence">
                                     <option value="NULL" selected="selected">未選択</option> 
                                    @foreach(config('pref') as $key => $score)
                                     <option value="{{ $score }}">{{ $score }}</option> 
                                    
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="hobby" class="col-form-label">趣味</label>
                            @foreach(config('hobby') as $key => $hobby)
                            <input type="checkbox" name="hobby[]" value={{ $hobby }}>{{ $hobby }}
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label for="height" class="col-form-label">身長</label>
                            <input type="number" id="height" name="height" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="weight" class="col-form-label">体型</label>
                            <select type="text" class="form-control" name="weight" required autocomplete="weight">
                                 <option value="NULL">未選択</option> 
                                @foreach(config('weight') as $key => $score)
                                 <option value="{{ $score }}">{{ $score }}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('検索') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

