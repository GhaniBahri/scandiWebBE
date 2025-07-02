<?php

declare(strict_types=1);

namespace App\Model\Attribute;

class SwatchAttribute extends Attribute
{
    public function getType(): string
    {
        return 'swatch';
    }

    public function getColorValues(): array
    {
        return array_map(fn ($opt) => $opt->getValue(), $this->getOptions());
    }
}
