<?php

declare(strict_types=1);

namespace App\Model\Attribute;

class TextAttribute extends Attribute
{
    public function getType(): string
    {
        return 'text';
    }
    
    // Text-specific methods can be added here
    public function getTextOptions(): array
    {
        return $this->getOptions();
    }
}