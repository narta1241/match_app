<!-- side bar -->
<div class="panel panel-default">
  <div class="panel-heading">
  <h3>Menu</h3>
  </div>
   <!--<div class="panel-body"> -->
        <ul class="nav nav-pills nav-stacked">
            <li><a href="{{ route('profiles.index') }}" class="glyphicon glyphicon-menu-right"> 探す</a></li>
            <li><a href="{{ route('favorites.index', ['pattern' => 'favoritting']) }}" class="glyphicon glyphicon-menu-right"> いいね一覧</a></li>
            <li><a href="{{ route('matchings.index') }}" class="glyphicon glyphicon-menu-right"> メッセージ</a></li>
            <li><a href="{{ route('footprints.index') }}" class="glyphicon glyphicon-menu-right"> 足あと</a></li>
            
            @guest
                <li class="nav-item"><a class="glyphicon glyphicon-menu-right" href="{{ route('login') }}">{{ __('　ログイン') }}</a></li>
                @if (Route::has('register'))
                    <li class="nav-item"><a class="glyphicon glyphicon-menu-right" href="{{ route('register') }}">{{ __('　アカウント登録') }}</a></li>
                @endif
            @else
                <li><a href="{{ route('profiles.edit', Auth::user()->id) }}" class="glyphicon glyphicon-menu-right"> プロフィール編集</a></li>
                <li><a href="{{ route('setting') }}" class="glyphicon glyphicon-menu-right"> ユーザー設定</a></li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="glyphicon glyphicon-menu-right dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} 
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('　ログアウト') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                       
                    </div>
                </li>
            @endguest
        </ul>
   <!--</div> -->
</div>
 @section('script')
          <!--  <form action="{{ asset('pay') }}" method="POST">-->
          <!--  {{ csrf_field() }}-->
          <!--  <script-->
          <!--       src="https://checkout.stripe.com/checkout.js" -->
          <!--       class="stripe-button text-center"-->
          <!--       data-key="{{ env('STRIPE_PUBLIC_KEY') }}"-->
          <!--       data-amount="500"-->
          <!--       data-name="Stripe決済デモ"-->
          <!--       data-label="決済をする"-->
          <!--       data-description="これはデモ決済です"-->
          <!--       data-image="https://stripe.com/img/documentation/checkout/marketplace.png"-->
          <!--       data-locale="auto"-->
          <!--       data-currency="JPY">-->
          <!--  </script>-->
          <!--</form>-->
          
        <script>
            
            // $('.stripe-button-el').attr('style', 'display: none;');
            // $(document).on('click', '#payment-submit', function() {
            //     $('.stripe-button-el').click()
            // })
        </script>
        @endsection
