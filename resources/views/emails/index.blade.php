@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- フラッシュメッセージ -->
            @if (session('flash_message'))
            <div class="flash_message alert-success text-center py-3 my-2">
                {{ session('flash_message') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header">メールアドレス変更</div>

                <div class="card-body">
                    新規メールアドレスを入力してください
                    <form action="/email" method="POST">
                        {{ csrf_field() }}
                        <input type="email" name="new_email">
                        <input type="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection