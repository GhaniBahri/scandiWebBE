<?php

declare(strict_types=1);

namespace App\Model\Currency;

class Currency
{
    public function __construct(
        protected string $label,
        protected string $symbol
    ) {}

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}