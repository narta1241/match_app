@extends('layouts.app')

@section('content')
<div class="loginPage">
  <div class="container">
        <h1 class="h3 loginPage_title">新しいマッチを見つけよう</h1>
        <div class="btn loginPage_btn"><a class="text-white" href="{{ route('login') }}">メールアドレスでログインする</a></div>
  </div>
</div>
@endsection