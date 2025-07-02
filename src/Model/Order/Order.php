<?php

namespace App\Model\Order;

use DateTime;

class Order
{
    public function __construct(
        protected int $id,
        protected float $total,
        protected string $currency,
        protected array $items,
        protected DateTime $createdAt
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getFormattedCreatedAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}
