<?php

namespace App\Enums;

enum PaymentType
{
    public const ONE_TIME = 'one_time';
    public const SUBSCRIPTION = 'recurring';

    public const TYPE_MAP = [
        self::ONE_TIME => 'One time',
        self::SUBSCRIPTION => 'Subscription',
    ];
}
