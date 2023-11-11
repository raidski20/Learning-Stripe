<?php

namespace App\Services\Stripe;

class ProductService extends BaseStripeService
{
    public function __construct()
    {
        parent::__construct();
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
