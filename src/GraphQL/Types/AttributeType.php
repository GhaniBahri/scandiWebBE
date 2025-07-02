<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Model\Attribute\Attribute;
use App\GraphQL\Types;

class AttributeType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Attribute',
            'description' => 'A product attribute with options',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'Unique identifier of the attribute',
                    'resolve' => function (Attribute $attribute) {
                        return $attribute->getId();
                    }
                ],
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Name of the attribute (e.g., Size, Color)',
                    'resolve' => function (Attribute $attribute) {
                        return $attribute->getName();
                    }
                ],
                'type' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Type of attribute (text or swatch)',
                    'resolve' => function (Attribute $attribute) {
                        return $attribute->getType();
                    }
                ],
                'options' => [
                    'type' => Type::nonNull(Type::listOf(Types::attributeOption())),
                    'description' => 'Available options for this attribute',
                    'resolve' => function (Attribute $attribute) {
                        return $attribute->getOptions();
                    }
                ]
            ]
        ]);
    }
}
