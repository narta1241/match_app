@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('プロフィール編集') }}</div>
                    <div class="card-body">
                        <form method="POST" action="/profiles/{{ $profile->id }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="col-form-label">名前</label>
                            <input type="text" id="name" name="name" class="form-control" value={{$profile->name}}>
                        </div>
                        <div>
                            <div>
                                <label for="image" class="col-form-label">{{ __('画像') }}</label>
                                <span id="image"><input type="file" id="image" name="image" accept="image/png, image/jpeg"></span>
                                <input type="button" value="クリア" onclick="sample('image')">
                            </div>
                            <label for="image" class="col-form-label">{{ __('前回登録画像') }}</label>
                            <img src="{{ Storage::url($profile->image_path) }}" alt="image" style="width: 30%; height: auto;"/>
                        </div>
                        <div class="form-group">
                            <label for="introduction" class="col-form-label text-md-right">自己紹介</label>
                            <input type="text" id="introduction" name="introduction" class="form-control" value={{ $profile->introduction }}>
                        </div>
                        <div class="form-group">
                            <label for="age" class="col-form-label text-md-right">年齢</label>
                            <input type="number" id="age" name="age" class="form-control" value={{ $profile->age }}>
                        </div>
                        <div class="form-group">
                    		<label>性別</label>
                    		<label for="sex_male"><input id="sex_male" type="radio" name="sex" value="0" <?php if( $profile->sex == '0' ){ echo 'checked'; } ?>>男性</label>
                    		<label for="sex_female"><input id="sex_female" type="radio" name="sex" value="1" <?php if( $profile->sex == '1' ){ echo 'checked'; } ?>>女性</label>
                    	</div>
                    	<div class="form-group">
                    		<label>誕生日</label>
                    		{{ Form::select('year', config('year'), $y, ['class' => 'form-control']) }}
                            
                    		{{ Form::select('month', config('month'), $m, ['class' => 'form-control']) }}
                            
                    		{{ Form::select('day', config('day'), $d, ['class' => 'form-control']) }}
                            
                    	</div>
                    	<div class="">
                    	    <label>居住地</label>
                                <select type="text" class="form-control @error('residence') is-invalid @enderror" name="residence" required autocomplete="residence">
                                     <option value="{{ $profile->residence }}" selected>{{ $profile->residence }}</option> 
                                    @foreach(config('pref') as $key => $score)
                                     <option value="{{ $score }}">{{ $score }}</option> 
                                    @endforeach
                                </select>
                        </div>
                         <div class="form-group">
                            <label for="hobby" class="col-form-label">趣味</label>
                            @foreach(config('hobby') as $key => $hobby)
                                @if($hob->CONTAINS($hobby))
                                    <input type="checkbox" name="hobby[]" value={{ $hobby }} checked>{{ $hobby }}
                                @else
                                    <input type="checkbox" name="hobby[]" value={{ $hobby }}>{{ $hobby }}
                                @endif
                            @endforeach
                        </div>
                         <div class="form-group">
                            <label for="height" class="col-form-label">身長</label>
                            <input type="text" id="height" name="height" class="form-control" value={{ $profile->height }}>
                        </div>
                        <div class="form-group">
                            <label for="weight" class="col-form-label">体型</label>
                            <select type="text" class="form-control" name="weight" required autocomplete="weight">
                                 <option value="{{ $profile->weight }}" selected="selected">{{ $profile->weight }}</option> 
                                @foreach(config('weight') as $key => $score)
                                 <option value="{{ $score }}">{{ $score }}</option> 
                                @endforeach
                            </select>
                        </div>
                            <div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('登録') }}
                                    </button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
  <script type="text/javascript">
function sample(oId){
	var obj = document.getElementById(oId);
	var stO = obj.innerHTML;
	obj.innerHTML = stO;
}
</script>