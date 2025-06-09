<?php

declare(strict_types=1);

namespace App\Model;

class AttributeOption
{
    public function __construct(
        protected string $id,
        protected string $displayValue,
        protected string $value
    ) {}
    
    public function getId(): string { return $this->id; }
    public function getDisplayValue(): string { return $this->displayValue; }
    public function getValue(): string { return $this->value; }
}