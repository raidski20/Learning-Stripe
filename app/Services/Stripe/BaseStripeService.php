<?php

namespace App\Services\Stripe;

use Stripe\StripeClient;

class BaseStripeService
{
    protected string $stripSK;
    protected StripeClient $stripe;

    public function __construct()
    {
        $this->stripSK = env('STRIPE_SECRET');
        $this->stripe = new StripeClient($this->stripSK);
    }
}
