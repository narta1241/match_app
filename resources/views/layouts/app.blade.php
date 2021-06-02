<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'match_app') }}</title>

    <!-- Scripts -->
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">
  

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="logo" src="/img/logo.png" alt="logo">
                </a>
        </nav>
        <!--<div class="container">-->
            <main class="py-4">
            <div class="row pl-4 pr-4" id="content">  
                    <div class="col-md-2">
                         <!-- サイドバー -->
                        @include('layouts.partials.sidebar', ['id' => Auth::id()])
                    </div>
                    <div class="col-md-10">
                        @if (session('flash_message'))
                            <div class="flash_message">
                                {{ session('flash_message') }}
                            </div>
                        @endif
                        @yield('content')
                        <div id="faq_csv_modal_window">
                        {{-- モーダルウィンドウ --}}
                        @include('layouts.partials.modal_window')
                        @section('modal_window')
                            <div id="modal_open">
                                <header id="modal_header" class="text-center mt-4 mb-2">
                                    <h3>~有料会員になると~</h3>
                                </header>
                                <main id="modal_main" class="text-center">
                                    <p>・マッチングユーザーとのメッセージ送受信が可能</p>
                                    <p>・有料会員の更新時期は月初です</p>
                                    <h2>月額/５００円</h2>
                                </main>
                                
                                <footer id="modal_footer" class="row">
                                    <p class="col-md-4" style="font-size: 12pt;"><a id="modal-close" class="button-link">閉じる</a></p>
                                    <div class="col-md-4"></div>
                                    <span class="col-md-4 text-right"><a href="javascript:void(0)" id="payment-submit" class="button">有料会員になる</a></span>
                                </footer>
                            </div>
                        @endsection
                        @yield('modal_window')
                        </div>
                    </div>
            </div>
            </main>
        <!--</div>-->
    </div>
     @yield('javascript')
     @yield('script')
</body>
</html>
