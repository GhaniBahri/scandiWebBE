<?php

declare(strict_types=1);

namespace App\Model;

class Category
{
    public string $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
    public function getName(): string
    {
        return $this->name;
    }
}
