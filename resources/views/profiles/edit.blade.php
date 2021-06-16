@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center prof">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('プロフィール編集') }}</div>
                    <div class="card-body">
                        <form method="POST" action="/profiles/{{ $profile->id }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                              <label for="name" class="col-form-label">名前：</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="name" name="name" value={{ $profile->name }}>
                                @if ($errors->first('name')) 
                                    <p class="validation text-danger">※{{$errors->first('name')}}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <div class="row form-group">
                                <div class="col-md-4 text-center">
                                    <label for="image" class="col-form-label">{{ __('画像：') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="file" id="myImage" name="image" accept="image/png, image/jpeg">
                                </div>
                            </div>
                            <div class="mb-4 text-center">
                                <label for="preview" class="col-form-label">{{ __(' プレビュー：') }}</label>
                                <img id="preview" style="width: 30%; height: 30%;">
                                <label for="image" class="col-form-label">{{ __('現在登録画像：') }}</label>
                                <img id="previewImage" src="data:image/png;base64,{{$profile->image}}" alt="image" style="width: 30%; height: 30%;"/>
                            </div>   
                        </div>
                        
                        
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                                <label for="introduction" class="col-form-label">自己紹介：</label>
                            </div>
                            <div class="col-md-8">
                                <textarea id="introduction" name="introduction" rows="3" style="width:100%;">{{ $profile->introduction }}</textarea>
                                @if ($errors->first('introduction')) 
                                    <p class="validation text-danger">※{{$errors->first('introduction')}}</p>
                                @endif
                            </div>
                        </div>
                       
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                    		    <label class="col-form-label">性別：</label>
                    		</div>
                    		<div class="col-md-8">
                        		<label for="sex_male"><input id="sex_male" type="radio" name="sex" value="0" <?php if( $profile->sex == '0' ){ echo 'checked'; } ?>>男性</label>
                        		<label for="sex_female"><input id="sex_female" type="radio" name="sex" value="1" <?php if( $profile->sex == '1' ){ echo 'checked'; } ?>>女性</label>
                    		</div>
                    	</div>
                    	<div class="row form-group">
                            <div class="col-md-4 text-center">
                    		    <label>誕生日：</label>
                    		</div>
                    		<div class="col-md-8">
                    	    	{{ Form::select('year', config('year'), $y, ['class' => 'form-control', 'style' => "width:50%;"]) }}
                    		</div>
                    	    <div class="col-md-4 text-center"></div>
                            <div class="col-md-8">
                    		    {{ Form::select('month', config('month'), $m, ['class' => 'form-control', 'style' => "width:50%;"]) }}
                    		</div>
                            <div class="col-md-4 text-center"></div>
                            <div class="col-md-8 mt-2">
                    		    {{ Form::select('day', config('day'), $d, ['class' => 'form-control', 'style' => "width:50%;"]) }}
                            </div>
                    	</div>
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                    	        <label>居住地：</label>
                    	    </div>
                    	    <div class="col-md-8">
                                <select type="text" class="form-control @error('residence') is-invalid @enderror" name="residence" required autocomplete="residence" style="width:50%;">
                                     <option value="{{ $profile->residence }}" selected>{{ $profile->residence }}</option> 
                                    @foreach(config('pref') as $key => $score)
                                     <option value="{{ $score }}">{{ $score }}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div>
                         <div class="row form-group">
                            <div class="col-md-4 text-center">
                                <label for="hobby" class="col-form-label">趣味：</label>
                            </div>
                            <div class="col-md-8">
                                @foreach(config('hobby') as $key => $hobby)
                                    <label>
                                        @if($hob->CONTAINS($hobby))
                                            <input type="checkbox" name="hobby[]" value={{ $hobby }} checked>{{ $hobby }}
                                        @else
                                            <input type="checkbox" name="hobby[]" value={{ $hobby }}>{{ $hobby }}
                                        @endif
                                    </label>
                                @endforeach
                                @if ($errors->first('hobby')) 
                                    <p class="validation text-danger">※{{$errors->first('hobby')}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                                <label for="height" class="col-form-label">身長：</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" id="height" name="height" class="form-control" max=210 min=140 value="{{ $profile->height }}" style="width:50%;">
                                @if ($errors->first('height')) 
                                    <p class="validation text-danger">※{{$errors->first('height')}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4 text-center">
                                <label for="weight" class="col-form-label">体型：</label>
                            </div>
                            <div class="col-md-8">
                                <select type="text" class="form-control" name="weight" required autocomplete="weight" style="width:50%;">
                                     <option value="{{ $profile->weight }}" selected="selected">{{ $profile->weight }}</option> 
                                    @foreach(config('weight') as $key => $score)
                                     <option value="{{ $score }}">{{ $score }}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary registration">
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

    <!--<script type="text/javascript">-->
    <!--function sample(oId){-->
    <!--	var obj = document.getElementById(oId);-->
    <!--	var stO = obj.innerHTML;-->
    <!--	obj.innerHTML = stO;-->
    <!--}-->
    <!--</script>-->
    
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

