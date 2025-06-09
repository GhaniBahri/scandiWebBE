<?php

declare(strict_types=1);

namespace App\Model\Category;

class Category
{
    public function __construct(
        protected string $name
    ) {}

    public function getName(): string
    {
        return $this->name;
    }
}