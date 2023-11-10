<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const EURO_CURRENCY = 'euro';
    const US_DOLLAR_CURRENCY = 'usd';

    public const CURRENCIES_MAP = [
        self::EURO_CURRENCY => 'Euro (€)',
        self::US_DOLLAR_CURRENCY => 'US Dollar ($)',
    ];

    protected $fillable = [
        'name',
        'price',
        'currency'
    ];
}
