<?php

namespace App\Services\Stripe;

use App\Models\User;
use Stripe\StripeClient;

class CustomerService
{
    private string $stripSK;
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripSK = env('STRIPE_SECRET');
        $this->stripe = new StripeClient($this->stripSK);
    }

    public function create(User $user): \Stripe\Customer
    {
        return $this->stripe->customers->create([
            'email' => $user->email,
            'name' => $user->name
        ]);
    }
}
