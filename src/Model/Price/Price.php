<?php

declare(strict_types=1);

namespace App\Model\Price;

use App\Model\Currency\Currency;

class Price
{
    public function __construct(
        protected float $amount,
        protected Currency $currency
    ) {}

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getFormatted(): string
    {
        return sprintf(
            '%s%.2f',
            $this->currency->getSymbol(),
            $this->amount
        );
    }
}