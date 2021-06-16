@extends('layouts.app')

@section('content')
<div class="loginPage">
  <div class="container">
        <h1 class="h3 loginPage_title">新しいマッチを見つけよう</h1>
        <div class="btn"><a class="text-white loginPage_btn" href="{{ route('login') }}">メールアドレスでログインする</a></div>
        <div class="mt-4"><a class="h3 loginPage_register" href="{{ route('register') }}" >新規登録</a></div>
  </div>
</div>
@endsection