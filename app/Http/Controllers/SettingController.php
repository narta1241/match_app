<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function setting()
    {
        $user = User::where('id', Auth::id())->first();
        
        $stripe = new \Stripe\StripeClient(
          env('STRIPE_SECRET_KEY'),
        );
        $response = $stripe->checkout->sessions->create([
          'success_url' => 'https://9d0cd6b219e94288b45c5ed587e35390.vfs.cloud9.ap-northeast-1.amazonaws.com/matchings',
          'cancel_url' => 'https://9d0cd6b219e94288b45c5ed587e35390.vfs.cloud9.ap-northeast-1.amazonaws.com/setting',
          'payment_method_types' => ['card'],
          'line_items' => [
            [
              'price' => 'price_1J0NFbH7v2PEnTHMZq14Ir2e',
              'quantity' => 1,
            ],
          ],
          'mode' => 'subscription',
        ]);
        
        return view('settings.index', compact('user', 'response'));
    }
}
