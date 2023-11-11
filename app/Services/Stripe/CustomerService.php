<?php

namespace App\Services\Stripe;

use App\Models\User;

class CustomerService extends BaseStripeService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(User $user): \Stripe\Customer
    {
        return $this->stripe->customers->create([
            'email' => $user->email,
            'name' => $user->name
        ]);
    }
}
