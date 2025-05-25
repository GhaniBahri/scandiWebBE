<?php

declare(strict_types = 1);

namespace App\Model;

class Attribute 
{
    private string $id;
    public string $name;
    public string $type;

    public function __construct(
        string $id,
        string $name,
        string $type
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }

}