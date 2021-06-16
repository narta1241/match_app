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
        $user = User::findOrFail($session['client_reference_id']);

        DB::transaction(function () use ($session, $user) {
            $user->update(['stripe_id' => $session['customer']]);

            $user->subscriptions()->create([
                'name'          => 'default',
                'stripe_id'     => $session['subscription'],
                'stripe_status' => 'active' // Or use "active" if you don't provide a trial
            ]);
        });

        return $this->successMethod();
    }
}