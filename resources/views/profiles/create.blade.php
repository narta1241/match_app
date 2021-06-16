@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center prof">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('プロフィール作成') }}</div>

                <div class="card-body">
                    <!--<form method="POST" action="{{ route('profiles.store') }}">-->
                    <form method="POST" action="{{ route('profiles.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                                <label for="name" class="col-form-label">名前：</label>
                            </div>
                            
                            <div class="col-md-8">
                                <input type="text" id="name" name="name" class="form-control" style="width:50%;">
                                @if ($errors->first('name')) 
                                    <p class="validation text-danger">※{{$errors->first('name')}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                                <label for="image" class="col-form-label">{{ __('画像：') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="file" id="myImage" name="image" accept="image/png, image/jpeg">
                                @if ($errors->first('image')) 
                                    <p class="validation text-danger">※{{$errors->first('image')}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                                <label for="preview" class="col-form-label">{{ __(' プレビュー：') }}</label>
                            </div>
                            <div class="col-md-8">
                                <img id="preview" style="width: 80%; height: auto;">
                            </div>
                        </div>
                       <div class="row form-group">
                            <div class="col-md-4 text-center">
                                <label for="introduction" class="col-form-label">{{ __(' 自己紹介：') }}</label>
                            </div>
                            <div class="col-md-8">
                                <textarea id="introduction" name="introduction" rows="3" style="width:100%"></textarea>
                                @if ($errors->first('introduction')) 
                                    <p class="validation text-danger">※{{$errors->first('introduction')}}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                    		    <label class="col-form-label">{{ __(' 性別：') }}</label>
                    		</div>
                    		<div class="col-md-8">
                        		<label for="sex_male"><input id="sex_male" type="radio" name="sex" value="0"<?php if( !empty($clean['sex']) && $clean['sex'] === "male" ){ echo 'checked'; } ?>>男性</label>
                        		<label for="sex_female"><input id="sex_female" type="radio" name="sex" value="1"  <?php if( !empty($clean['sex']) && $clean['sex'] === "female" ){ echo 'checked'; } ?>>女性</label>
                        		@if ($errors->first('sex')) 
                                    <p class="validation text-danger">※{{$errors->first('sex')}}</p>
                                @endif
                    		</div>
                    	</div>
                       <div class="row form-group">
                            <div class="col-md-4 text-center">
                    		    <label>{{ __(' 誕生日：') }}</label>
                    		</div>
                    		<div class="col-md-8">
                    	    	{{ Form::select('year', config('year'), null, ['class' => 'form-control', 'style' => "width:50%;" , 'placeholder' => '選択してください']) }}
                    	    	@if ($errors->first('year')) 
                                    <p class="validation text-danger">※{{$errors->first('year')}}</p>
                                @endif
                    		</div>
                    	    <div class="col-md-4 text-center"></div>
                            <div class="col-md-8">
                    		    {{ Form::select('month', config('month'), null, ['class' => 'form-control', 'style' => "width:50%;",  'placeholder' => '選択してください']) }}
                    		    @if ($errors->first('month')) 
                                    <p class="validation text-danger">※{{$errors->first('month')}}</p>
                                @endif
                    		</div>
                            <div class="col-md-4 text-center"></div>
                            <div class="col-md-8 mt-2">
                    		    {{ Form::select('day', config('day'), null, ['class' => 'form-control', 'style' => "width:50%;",  'placeholder' => '選択してください']) }}
                    		    @if ($errors->first('day')) 
                                    <p class="validation text-danger">※{{$errors->first('day')}}</p>
                                @endif
                            </div>
                    	</div>
                    	<div class="row form-group">
                            <div class="col-md-4 text-center">
                    	        <label>{{ __(' 居住地：') }}</label>
                    	    </div>
                    	    <div class="col-md-8">
                                <select type="text" class="form-control @error('residence') is-invalid @enderror" name="residence" required autocomplete="residence" style="width:50%;">
                                     <option value="" selected="selected">選択してください</option> 
                                    @foreach(config('pref') as $key => $score)
                                     <option value="{{ $score }}">{{ $score }}</option> 
                                    
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                                <label for="hobby" class="col-form-label">{{ __(' 趣味：') }}</label>
                            </div>
                            <div class="col-md-8">
                                @foreach(config('hobby') as $key => $hobby)
                                <label>
                                    <input type="checkbox" name="hobby[]" value={{ $hobby }}>{{ $hobby }}
                                </label>
                                @endforeach
                                 @if ($errors->first('hobby')) 
                                    <p class="validation text-danger">※{{$errors->first('hobby')}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                                <label for="height" class="col-form-label">{{ __(' 身長：') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" id="height" name="height" class="form-control" max=210 min=140 style="width:50%;">
                                @if ($errors->first('height')) 
                                    <p class="validation text-danger">※{{$errors->first('height')}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                                <label for="weight" class="col-form-label">{{ __(' 体型：') }}</label>
                            </div>
                            <div class="col-md-8">
                            <select type="text" class="form-control" name="weight" required autocomplete="weight" style="width:50%;">
                                 <option value="" selected="selected">選択してください</option> 
                                @foreach(config('weight') as $key => $score)
                                 <option value="{{ $score }}">{{ $score }}</option> 
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary registration">
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