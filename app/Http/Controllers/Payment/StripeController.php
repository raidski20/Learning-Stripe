<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function success(Request $request)
    {
        try {
            $session = $this->stripe->checkout->sessions->retrieve($request->get('session_id'));

            $customer = $this->stripe->customers->retrieve($session->customer);

            return view('stripe.success', compact('customer'));

        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
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
            'success_url' => route('payment.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
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
