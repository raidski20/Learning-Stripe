<?php

namespace App\Services\Stripe;

use App\Enums\PaymentType;
use App\Models\User;

class CheckoutSession extends BaseStripeService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createCheckoutSession(string $stripe_price, User $user): \Stripe\Checkout\Session
    {
        $customerId = $user->resolveStripeCustomerId();

        // This line is optional and may not be at all,
        // since I'm learning phase, I added it just to save time
        $stripePriceObj = $this->stripe->prices->retrieve($stripe_price);

        $checkoutData = [
            //'payment_method_types' => ['card', 'paypal'],
            'customer' => $customerId,
            'line_items' => [[
                'price' => $stripe_price,
                'quantity' => 1,
            ]],
            'success_url' => route('stripe.payment.success'),
            'cancel_url' => route('stripe.payment.cancel'),
        ];

        if ($stripePriceObj->type === PaymentType::ONE_TIME) {
            $checkoutData['mode'] = 'payment';
        } else {
            $checkoutData['mode'] = 'subscription';
        }

        return $this->stripe->checkout->sessions->create($checkoutData);
    }
}
