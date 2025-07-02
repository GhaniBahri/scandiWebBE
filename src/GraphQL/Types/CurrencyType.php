<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Model\Currency\Currency;
use App\GraphQL\Types;

class CurrencyType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Currency',
            'description' => 'Currency information',
            'fields' => [
                'label' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Currency label (e.g., USD)',
                    'resolve' => function (Currency $currency) {
                        return $currency->getLabel();
                    }
                ],
                'symbol' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Currency symbol (e.g., $)',
                    'resolve' => function (Currency $currency) {
                        return $currency->getSymbol();
                    }
                ]
            ]
        ]);
    }
}
