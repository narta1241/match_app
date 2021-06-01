<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\User;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
   public function pay(Request $request){
     Stripe::setApiKey(env('STRIPE_SECRET_KEY'));//シークレットキー
   //  dd($request);
      
           $charge = Charge::create(array(
            'amount' => 500,
            'currency' => 'jpy',
            'source'=> request()->stripeToken,
           ));
          User::where('id', Auth::id())->update(['billing' => 1]);
         //  $user->billing = 1;
         //  $user->save;
         //  dd($user);
      return back();
     }
    public function payout(Request $request){
        User::where('id', Auth::id())->update(['billing' => 0]);
        return back();
    }
}
