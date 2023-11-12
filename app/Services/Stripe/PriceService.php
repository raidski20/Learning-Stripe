<?php

namespace App\Services\Stripe;

use App\Enums\PaymentType;

class PriceService extends BaseStripeService
{
    // Used to convert price to cents
    public const PRICE_MULTIPLIER = 100;

    public function __construct()
    {
        parent::__construct();
    }

    public function create(array $productData, string $stripeProductId): \Stripe\Price
    {
        $priceData = [
            'currency' => $productData['currency'],
            'unit_amount' => ((float) $productData['price']) * self::PRICE_MULTIPLIER,
            'product' => $stripeProductId,
        ];

        if ($productData['payment_type'] === PaymentType::SUBSCRIPTION) {
            $priceData['recurring'] = [
                'interval' => $productData['interval'],
            ];
        }

        return $this->stripe->prices->create($priceData);
    }
}
