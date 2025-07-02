<?php

declare(strict_types=1);

namespace App\Model\Attribute;

use App\Model\AttributeOption;

abstract class Attribute
{
    protected array $options = [];

    public function __construct(
        protected string $id,
        protected string $name
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function addOption(AttributeOption $option): void
    {
        $this->options[] = $option;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    abstract public function getType(): string;
}
