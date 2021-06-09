<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\User;
use App\Payment;

use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
   public function pay(Request $request){
     Stripe::setApiKey(env('STRIPE_SECRET_KEY'));//シークレットキー
    //   dd($request);
      $customer = \Stripe\Customer::create([
                'payment_method' => $request->tokenstripeToken,
                'name' => Auth::user()->name,
                'invoice_settings' => [
                    'default_payment_method' => $request->tokenstripeToken, // デフォルトで使用する支払い方法。必須。
                ],
            ]);
        //   $charge = Charge::create(array(
        //     'amount' => 500,
        //     'currency' => 'jpy',
        //     'source'=> request()->stripeToken,
        //   ));
          $subscription =  \Stripe\Subscription::create([
              "customer" => "$customer->id",
              'items' => [
                [
                  "plan" => 'price_1J0NFbH7v2PEnTHMZq14Ir2e',
                ],
              ],
           ]);
            dd($subscription);
            $sub_id = $subscription->id;
           Payment::create([
                'stripe_id' => $sub_id,
                'email' => $request->stripeEmail,
                ]);
    // dd($request);
        //   $subscription =  \Stripe\Subscription::create(
        //       array(
        //       "customer" => Auth::id(),
        //       "items" => array( array("plan" => "id-test",), )
        //       )
        //     );
        //     dd($subscription);
          User::where('id', Auth::id())->update(['billing' => 1]);
         
      return back();
      /**
         * フロントエンドから送信されてきたtokenを取得
         * これがないと一切のカード登録が不可
         **/
        // $token = $request->stripeToken;
        // $user = Auth::user(); //要するにUser情報を取得したい
        // $ret = null;
        /**
         * 当該ユーザーがtokenもっていない場合Stripe上でCustomer（顧客）を作る必要がある
         * これがないと一切のカード登録が不可
         **/
        // if ($token) {
        // dd($user);

            /**
             *  Stripe上にCustomer（顧客）が存在しているかどうかによって処理内容が変わる。
             *
             * 「初めての登録」の場合は、Stripe上に「Customer（顧客」と呼ばれる単位の登録をして、その後に
             * クレジットカードの登録が必要なので、一連の処理を内包しているPaymentモデル内のsetCustomer関数を実行
             *
             * 「2回目以降」の登録（別のカードを登録など）の場合は、「Customer（顧客」を新しく登録してしまうと二重顧客登録になるため、
             *  既存のカード情報を取得→削除→新しいカード情報の登録という流れに。
             *
             **/

            // if (!$user->stripe_id) {
                // $result = Payment::setCustomer($token, $user);
                // Payment::create([
                // 'stripe_id' => Auth::id(),
                // 'email' => $request->email,
                // ]);
                // /* card error */
                // if(!$result){
                //     $errors = "カード登録に失敗しました。入力いただいた内容に相違がないかを確認いただき、問題ない場合は別のカードで登録を行ってみてください。";
                //     return redirect('setting')->with('errors', $errors);
                // }

            // } 
        //     else {
        //         $defaultCard = Payment::getDefaultcard($user);
        //         // dd($defaultCard);
        //         if (isset($defaultCard['id'])) {
        //             Payment::deleteCard($user);
        //         }

        //         $result = Payment::updateCustomer($token, $user);

        //         /* card error */
        //         if(!$result){
        //             $errors = "カード登録に失敗しました。入力いただいた内容に相違がないかを確認いただき、問題ない場合は別のカードで登録を行ってみてください。";
        //             return redirect('setting')->with('errors', $errors);
        //         }

        //     }
        // } else {
        //     return redirect('setting')->with('errors', '申し訳ありません、通信状況の良い場所で再度ご登録をしていただくか、しばらく立ってから再度登録を行ってみてください。');
        // }


        // return redirect('setting')->with("success", "カード情報の登録が完了しました。");
     }
    public function payout(Request $request){
        
        $user_id = Payment::where('stripe_id', Auth::id())->first();
        $user = User::find(Auth::id());
        $user->update(['billing' => 0]);
        $matchAddress = Payment::where('email',$user->email)->first();
        // dd($matchAddress);
        if($matchAddress){
            $result = Payment::deleteCard($user_id);
            $matchAddress->delete();
            if($result){
                return redirect('setting')->with('success', 'カード情報の削除が完了しました。');
            }else{
                return redirect('setting')->with('errors', 'カード情報の削除に失敗しました。恐れ入りますが、通信状況の良い場所で再度お試しいただくか、しばらく経ってから再度お試しください。');
            }
        }
        return back();
    }
}
