<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Stripe\StripeClient;

class StripeController extends Controller
{
    private string $stripSK;
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripSK = env('STRIPE_SECRET');
        $this->stripe = new StripeClient($this->stripSK);
    }

    public function overview(): View
    {
        return view('stripe.checkout');
    }

    public function checkout()
    {
        $lineItems = $this->getLineItems();

        $checkout_session = $this->createCheckoutSession($lineItems);

        return redirect($checkout_session->url);
    }

    public function success()
    {
        echo "Payment success";
        exit;
    }

    public function cancel()
    {
        return "Payment canceled";
        exit;
    }

    private function createCheckoutSession(array $lineItems): \Stripe\Checkout\Session
    {
        return $this->stripe->checkout->sessions->create([
            'customer' => $this->createCustomer()->id,
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('payment.success', [], true),
            'cancel_url' => route('payment.cancel', [], true),
        ]);
    }

    private function getLineItems(): array
    {
        $products = \App\Models\Product::all();
        $lineItems = [];

        foreach ($products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $product->price * 100,
                    'product_data' => [
                        'name' => $product->name,
                    ],
                ],
                'quantity' => 1,
            ];
        }

        return $lineItems;
    }

    private function createCustomer(): \Stripe\Customer
    {
        $randomUserId = random_int(1, 10);

        $user = \App\Models\User::where('id', $randomUserId)->first();

        return $this->stripe->customers->create([
            'email' => $user->email,
            'name' => $user->name,
        ]);
    }
}
