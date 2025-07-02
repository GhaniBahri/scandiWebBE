<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Model\AttributeOption;
use App\GraphQL\Types;

class AttributeOptionType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'AttributeOption',
            'description' => 'An option for a product attribute',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'Unique identifier of the option',
                    'resolve' => function (AttributeOption $option) {
                        return $option->getId();
                    }
                ],
                'displayValue' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Display-friendly value',
                    'resolve' => function (AttributeOption $option) {
                        return $option->getDisplayValue();
                    }
                ],
                'value' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Actual value of the option',
                    'resolve' => function (AttributeOption $option) {
                        return $option->getValue();
                    }
                ]
            ]
        ]);
    }
}
