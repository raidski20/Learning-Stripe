<?php

namespace App\Services\Stripe;

use Stripe\StripeClient;

class ProductService
{
    private string $stripSK;
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripSK = env('STRIPE_SECRET');
        $this->stripe = new StripeClient($this->stripSK);
    }

    public function create(array $productData): \Stripe\Price
    {
        $stripeProduct = $this->stripe->products->create([
            'name' => $productData['name'],
        ]);

        return $this->stripe->prices->create([
            'currency' => $productData['currency'],
            'unit_amount' => ((float) $productData['price']) * 100,
            'product' => $stripeProduct->id,
        ]);
    }
}
