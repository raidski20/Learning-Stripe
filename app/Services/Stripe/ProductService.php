<?php

namespace App\Services\Stripe;

class ProductService extends BaseStripeService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(array $productData): \Stripe\Product
    {
        return $this->stripe->products->create([
            'name' => $productData['name'],
        ]);
    }

}
