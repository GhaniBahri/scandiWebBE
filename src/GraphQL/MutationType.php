<?php

namespace App\GraphQL;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Types ;
use App\GraphQL\Resolvers\OrderResolver;

class MutationType extends ObjectType
{
    public static function get(): self
    {
        return new self([
            'name' => 'Mutation',
            'fields' => [
                'createOrder' => [
                    'type' => Types::order(),
                    'description' => 'Create a new order',
                    'args' => [
                        'input' => [
                            'type' => Type::nonNull(Types::orderInput()),
                            'description' => 'Order input data'
                        ]
                    ],
                    'resolve' => function ($root, $args) {
                        return OrderResolver::createOrder($args['input']);
                    }
                ]
            ]
        ]);
    }
}
