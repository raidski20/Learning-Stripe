<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    private string $stripSK;
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripSK = env('STRIPE_SECRET');
        $this->stripe = new StripeClient($this->stripSK);
    }

    public function checkout(Request $request)
    {
        // Getting a random user instead of the authenticated one,
        // because authentication system is not set up
        $user = User::where('id', random_int(1, 3))->first();

        $checkout_session = $this->createCheckoutSession($request->product_id, $user);

        return redirect($checkout_session->url);
    }

    private function createCheckoutSession(string $stripe_price, User $user): \Stripe\Checkout\Session
    {
        $customerId = $user->resolveStripeCustomerId();

        $lineItems = [[
            'price' => $stripe_price,
            'quantity' => 1,
        ]];

        return $this->stripe->checkout->sessions->create([
            'customer' => $customerId,
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.payment.success'),
            'cancel_url' => route('stripe.payment.cancel'),
        ]);
    }

    public function success(): string
    {
        return "Payment success";
    }

    public function cancel()
    {
        return "Payment canceled";
    }
}
