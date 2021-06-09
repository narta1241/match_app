@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('プロフィール作成') }}</div>

                <div class="card-body">
                    <!--<form method="POST" action="{{ route('profiles.store') }}">-->
                    <form method="POST" action="{{ route('profiles.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label">名前</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div>
                            <label for="image" class="col-form-label">{{ __('画像') }}</label>
                            <input type="file" id="myImage" name="image" accept="image/png, image/jpeg">
                                
                            <label for="preview" class="col-form-label">{{ __(' プレビュー ') }}</label>
                            <img id="preview" style="width: 30%; height: 30%;">
                        </div>
                        <div class="form-group">
                            <label for="introduction" class="col-form-label text-md-right">自己紹介</label>
                            <input type="text" id="introduction" name="introduction" class="form-control">
                        </div>
                        
                        <div class="form-group">
                    		<label>性別</label>
                    		<label for="sex_male"><input id="sex_male" type="radio" name="sex" value="0"<?php if( !empty($clean['sex']) && $clean['sex'] === "male" ){ echo 'checked'; } ?>>男性</label>
                    		<label for="sex_female"><input id="sex_female" type="radio" name="sex" value="1"  <?php if( !empty($clean['sex']) && $clean['sex'] === "female" ){ echo 'checked'; } ?>>女性</label>
                    	</div>
                        <div class="form-group">
                    		<label>誕生日</label>
                            <select type="text" class="form-control" name="year">
                                <option value="">--</option>
                                @foreach(range(1969,2005) as $year)
                                <option value="<?=$year?>"><?=$year?></option>
                                @endforeach
                            </select>
                            <select type="text" class="form-control" name="month">
                                <option value="">--</option>
                                @foreach(range(1,12) as $month)
                                <option value="<?=str_pad($month,2,0,STR_PAD_LEFT)?>"><?=$month?></option>
                                @endforeach
                            </select>
                            <select type="text" class="form-control" name="day">
                                <option value="">--</option>
                                @foreach(range(1,31) as $day)
                                <option value="<?=str_pad($day,2,0,STR_PAD_LEFT)?>"><?=$day?></option>
                                @endforeach
                            </select>
                    	</div>
                    	<div class="">
                    	    <label>居住地</label>
                                <select type="text" class="form-control @error('residence') is-invalid @enderror" name="residence" required autocomplete="residence">
                                     <option value="" selected="selected">選択してください</option> 
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
                            <input type="text" id="height" name="height" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="weight" class="col-form-label">体型</label>
                            <select type="text" class="form-control" name="weight" required autocomplete="weight">
                                 <option value="" selected="selected">選択してください</option> 
                                @foreach(config('weight') as $key => $score)
                                 <option value="{{ $score }}">{{ $score }}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('登録') }}
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

@section('javascript')
    
    <script type="text/javascript">
        $(document).on('change', 'input[type="file"]',  function (e) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#preview").attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    </script>
@endsection