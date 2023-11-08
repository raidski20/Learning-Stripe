<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Product;
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

    public function overview()
    {
        return view('stripe.checkout');
    }

    public function checkout()
    {
        $products = Product::all();
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

        $checkout_session = $this->stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('payment.success', [], true),
            'cancel_url' => route('payment.cancel', [], true),
        ]);

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
}
