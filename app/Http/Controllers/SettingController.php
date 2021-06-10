<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function setting(Request $request)
    {
        $user = Auth::user();
        
        $stripe = new \Stripe\StripeClient(
          env('STRIPE_SECRET'),
        );
        $response = $stripe->checkout->sessions->create([
          'success_url' => $request->getSchemeAndHttpHost(). '/matchings',
          'cancel_url' => $request->getSchemeAndHttpHost(). '/setting',
          'payment_method_types' => ['card'],
          'client_reference_id' => Auth::id(),
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
