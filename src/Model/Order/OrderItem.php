<?php

namespace App\Model\Order;

class OrderItem
{
    public function __construct(
        protected int $order_id,
        protected string $productId,
        protected int $quantity,
        protected array $attributes,
        protected float $price
    ) {
    }

    public function getId(): int
    {
        return $this->order_id;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getTotalPrice(): float
    {
        return $this->price * $this->quantity;
    }
}
