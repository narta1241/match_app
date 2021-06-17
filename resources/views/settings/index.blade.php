@extends('layouts.app')
 
@section('content')
<div class="container">
    <div class="text-center setting">
        <nav aria-label="設定">
            <li class="" style="font-size:20px;">
                <a class="glyphicon glyphicon-menu-right" style="color:black;" href="{{ route('emails.index') }}">
                    {{ __('　メールアドレス変更') }}
                </a>
            </li>
            <li>
                <a class="glyphicon glyphicon-menu-right" style="color:black;" href="{{ route('user.password.edit') }}">
                    {{ __('　パスワード変更') }}
                </a>
            </li>
            <li>
                <a class="glyphicon glyphicon-menu-right" style="color:black;" href="{{ route('blocks.index') }}">
                    {{ __('　ブロックしたユーザー') }}
                </a>
            </li>
            @if ($user->billing == 1)
                <li>
                    <a class="glyphicon glyphicon-menu-right" style="color:black;" href="{{ route('payout') }}" onclick="if(confirm('本当に有料会員を辞めますか?')) { return true } else {return false };">
                        {{ __('　有料会員を辞める') }}
                    </a>
                </li>
                @else
                <li>
                    <a href="javascript:void(0)" style="color:black;" id="modal-open" class="glyphicon glyphicon-menu-right">
                        {{ __('　有料会員になる') }}
                    </a>
                </li>
                <li>
                    <a class="glyphicon glyphicon-menu-right" style="color:black;" href="{{ route('profiles.withdrawal', Auth::user()->id) }}" onclick="if(confirm('本当に退会しますか?')) { return true } else {return false };">
                            {{ __('　退会する') }}
                    </a>
                </li>
                @endif
        </nav>
        
    </div>
</div>
@endsection

@include('layouts.partials.modal_window')