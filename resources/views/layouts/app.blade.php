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
    <script src="https://js.stripe.com/v3/"></script>
    
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen" id="bootstrap-css">
    

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

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
                        @if($_SERVER['REQUEST_URI'] != '/profiles/create')
                            @include('layouts.partials.sidebar', ['id' => Auth::id()])
                        @endif
                    </div>
                    <div class="col-md-10">
                        
                        <!-- フラッシュメッセージ -->
                        @if (session('flash_message'))
                            <div class="flash_message">
                                {{ session('flash_message') }}
                            </div>
                        @endif
                        @yield('content')
                        <div id="faq_csv_modal_window">
                        {{-- モーダルウィンドウ --}}
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
   
            
            
           