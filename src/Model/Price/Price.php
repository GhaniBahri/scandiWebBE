<?php

declare(strict_types=1);

namespace App\Model;

class Price
{
    public float $amount;
    public array $currency;

    public function __construct(
        float $amount,
        array $currency
    ) {
        $this->amount = $amount;
        $this->currency = $currency;
    }
    public function addcurrency(array $currency): void
    {
        $this->currency[] = $currency;
    }
}
