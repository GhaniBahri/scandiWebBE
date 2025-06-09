<?php

declare(strict_types=1);

namespace App\Model\Product;

use App\Model\Attribute\Attribute;
use App\Model\Attribute\TextAttribute;
use App\Model\Attribute\SwatchAttribute;
use InvalidArgumentException;

class TechProduct extends Product
{
    /**
     * Add a tech-specific attribute
     * @throws InvalidArgumentException
     */
    public function addAttribute(Attribute $attribute): void
    {
        $this->validateTechAttribute($attribute);
        parent::addAttribute($attribute);
    }

    /**
     * Set tech-specific attributes
     * @param Attribute[] $attributes
     * @throws InvalidArgumentException
     */
    public function setAttributes(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            $this->validateTechAttribute($attribute);
        }
        $this->attributes = $attributes;
    }

    /**
     * Validate that attribute is appropriate for tech products
     * @throws InvalidArgumentException
     */
    private function validateTechAttribute(Attribute $attribute): void
    {
        if (!$attribute instanceof TextAttribute && 
            !$attribute instanceof SwatchAttribute) {
            throw new InvalidArgumentException(
                'TechProduct only accepts TextAttribute or SwatchAttribute instances'
            );
        }
    }
}