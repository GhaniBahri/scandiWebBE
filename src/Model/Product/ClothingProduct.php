<?php

declare(strict_types=1);

namespace App\Model\Product;

use App\Model\Attribute\Attribute;
use InvalidArgumentException;

class ClothingProduct extends Product
{
    public function addAttribute(Attribute $attribute): void
    {
        $this->validateClothingAttribute($attribute);
        parent::addAttribute($attribute);
    }

    public function setAttributes(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            $this->validateClothingAttribute($attribute);
        }
        $this->attributes = $attributes;
    }

    private function validateClothingAttribute(Attribute $attribute): void
    {
        if (!$attribute instanceof \App\Model\Attribute\TextAttribute) {
            throw new InvalidArgumentException(
                'ClothingProduct only accepts TextAttribute instances'
            );
        }
    }
    public function getProductType(): string
    {
        return 'clothing';
    }
}
