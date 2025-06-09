<?php

declare(strict_types=1);

namespace App\Model\Product;

use App\Model\Attribute\Attribute;
use InvalidArgumentException;

class ClothingProduct extends Product
{
    /**
     * Add a clothing-specific attribute
     * @throws InvalidArgumentException
     */
    public function addAttribute(Attribute $attribute): void
    {
        $this->validateClothingAttribute($attribute);
        parent::addAttribute($attribute);
    }

    /**
     * Set clothing-specific attributes
     * @param Attribute[] $attributes
     * @throws InvalidArgumentException
     */
    public function setAttributes(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            $this->validateClothingAttribute($attribute);
        }
        $this->attributes = $attributes;
    }

    /**
     * Validate that attribute is appropriate for clothing products
     * @throws InvalidArgumentException
     */
    private function validateClothingAttribute(Attribute $attribute): void
    {
        if (!$attribute instanceof \App\Model\Attribute\TextAttribute) {
            throw new InvalidArgumentException(
                'ClothingProduct only accepts TextAttribute instances'
            );
        }
    }
}