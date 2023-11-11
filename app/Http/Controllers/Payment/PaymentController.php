<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
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
        $checkout_session = $this->createCheckoutSession($request->product_id);

        return redirect($checkout_session->url);
    }

    private function createCheckoutSession(string $stripe_price): \Stripe\Checkout\Session
    {
        $lineItems = [[
            'price' => $stripe_price,
            'quantity' => 1,
        ]];

        return $this->stripe->checkout->sessions->create([
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
