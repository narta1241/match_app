<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use App\User;

class StripeWebhookController extends CashierController
{
    public function handleCheckoutSessionCompleted(array $payload)
    {
        $session = $payload['data']['object'];
        $user = User::find((int) $session['client_reference_id']);
        
        \Log::debug('Session', $session);
        \Log::debug('ユーザー', ['user_id' => $user->id, 'stripe_id' => $user->stripe_id]);

        DB::transaction(function () use ($session, $user) {
            \Log::debug('Session Stripe ID', ['stripe_id' => $session['customer']]);
            
            $user->stripe_id = $session['customer'];
            $user->save();
            
            \Log::debug('ユーザー', ['user_id' => $user->id, 'stripe_id' => $user->stripe_id]);

            $user->subscriptions()->create([
                'name'          => 'default',
                'stripe_id'     => $session['subscription'],
                'stripe_status' => 'active' // Or use "active" if you don't provide a trial
            ]);
        });

        return $this->successMethod();
    }
}