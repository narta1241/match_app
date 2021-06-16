<!-- side bar -->
<div class="panel panel-default">
  <div class="panel-heading">
  <h2>Menu</h2>
  </div>
   <!--<div class="panel-body"> -->
        <ul class="nav nav-pills nav-stacked">
            <li><a href="{{ route('profiles.index') }}"><i class="fa fa-search "></i>{{ __('　探す') }}</a></li>
            <li><a href="{{ route('favorites.index', ['pattern' => 'favoritting']) }}"><i class="fa fa-heart-o "></i>{{ __('　いいね一覧') }}</a></li>
            <li><a href="{{ route('matchings.index') }}"><i class="fa fa-commenting-o "></i>{{ __('　メッセージ') }}</a></li>
            <li><a href="{{ route('footprints.index') }}"><i class="fa fa-paw "></i> {{ __('　足あと') }}</a></li>
            
            @guest
                <li class="nav-item"><a href="{{ route('login') }}"><i class="fa fa-sign-in "></i> {{ __('　ログイン') }}</a></li>
                @if (Route::has('register'))
                    <li class="nav-item"><a href="{{ route('register') }}"><i class="fa fa-male "></i> {{ __('　アカウント登録') }}</a></li>
                @endif
            @else
                <li><a href="{{ route('profiles.edit', Auth::user()->id) }}"><i class="fa fa-user "></i>  {{ __('　プロフィール編集') }}</a></li>
                <li><a href="{{ route('setting') }}"><i class="fa fa-wrench "></i> {{ __('　ユーザー設定') }}</a></li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fa fa-bullseye "></i> {{ __('　').Auth::user()->name }} 
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out "></i> {{ __('　ログアウト') }}
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
