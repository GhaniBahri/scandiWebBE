<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Model\Price\Price;
use App\GraphQL\Types;

class PriceType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Price',
            'description' => 'Price information for a product',
            'fields' => [
                'amount' => [
                    'type' => Type::nonNull(Type::float()),
                    'description' => 'The numerical amount of the price',
                    'resolve' => function (Price $price) {
                        return $price->getAmount();
                    }
                ],
                'currency' => [
                    'type' => Type::nonNull(Types::currency()),
                    'description' => 'The currency of the price',
                    'resolve' => function (Price $price) {
                        return $price->getCurrency();
                    }
                ],
                'formatted' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Formatted price with currency symbol',
                    'resolve' => function (Price $price) {
                        return $price->getFormatted();
                    }
                ]
            ]
        ]);
    }
}
