@section('modal_window')
<div id="modal-content">
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
            <span class="col-md-4 text-right"><button type="button" id="payment-checkout" class="button">有料会員になる</button></span>
        </footer>
    </div>
</div>

<script>
$(function(){
    //モーダルウィンドウを出現させるクリックイベント
    $("#modal-open").click( function(){

        //キーボード操作などにより、オーバーレイが多重起動するのを防止する
        $( this ).blur() ;  //ボタンからフォーカスを外す
        if( $( "#modal-overlay" )[0] ) return false ;       //新しくモーダルウィンドウを起動しない (防止策1)
        //if($("#modal-overlay")[0]) $("#modal-overlay").remove() ;     //現在のモーダルウィンドウを削除して新しく起動する (防止策2)

        //オーバーレイを出現させる
        $( "body" ).append( '<div id="modal-overlay"></div>' ) ;
        $( "#modal-overlay" ).fadeIn( "slow" ) ;

        //コンテンツをセンタリングする
        centeringModalSyncer() ;

        //コンテンツをフェードインする
        $( "#modal-content" ).fadeIn( "slow" ) ;

        //[#modal-overlay]、または[#modal-close]をクリックしたら…
        $( "#modal-overlay,#modal-close" ).unbind().click( function(){

            //[#modal-content]と[#modal-overlay]をフェードアウトした後に…
            $( "#modal-content,#modal-overlay" ).fadeOut( "slow" , function(){

                //[#modal-overlay]を削除する
                $('#modal-overlay').remove() ;

            } ) ;

        } ) ;

    } ) ;

    //リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
    $( window ).resize( centeringModalSyncer ) ;

    //センタリングを実行する関数
    function centeringModalSyncer() {

        //画面(ウィンドウ)の幅、高さを取得
        var w = $( window ).width() ;
        var h = $( window ).height() ;

        // コンテンツ(#modal-content)の幅、高さを取得
        // jQueryのバージョンによっては、引数[{margin:true}]を指定した時、不具合を起こします。
//      var cw = $( "#modal-content" ).outerWidth( {margin:true} );
//      var ch = $( "#modal-content" ).outerHeight( {margin:true} );
        var cw = $( "#modal-content" ).outerWidth();
        var ch = $( "#modal-content" ).outerHeight();

        //センタリングを実行する
        $( "#modal-content" ).css( {"left": ((w - cw)/2) + "px","top": ((h - ch)/2) + "px"} ) ;
    }
    
    let stripe = Stripe("{{ env('STRIPE_PUBLIC_KEY') }}");
    
    $('#payment-checkout').click(function() {
        console.log('test')
        stripe
            .redirectToCheckout({
              sessionId: '{{ $response->id }}'
            })
            .then(handleResult);
    });
});
</script>
@endsection