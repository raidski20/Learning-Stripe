<?php

namespace App\Enums;

enum RecurringFrequency
{
    public const DAILY = 'day';
    public const WEEKLY = 'week';
    public const MONTHLY = 'month';
    public const YEARLY = 'year';

    public const FREQUENCY_MAP = [
        self::DAILY => 'Daily',
        self::WEEKLY => 'Weekly',
        self::MONTHLY => 'Monthly',
        self::YEARLY => 'Yearly'
    ];
}
