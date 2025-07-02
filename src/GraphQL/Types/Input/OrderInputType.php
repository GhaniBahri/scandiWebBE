<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Input;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Types\Input\OrderItemInputType;

class OrderInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'OrderInput',
            'description' => 'Input for creating a new order',
            'fields' => [
                'items'    => [
                    'type' => Type::nonNull(
                        Type::listOf(
                            Type::nonNull(new OrderItemInputType())
                        )
                    ),
                    'description' => 'List of items to include in the order',
                ],
                'currency' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Currency code for the order (e.g., USD)',
                ],
                'total'    => [
                    'type' => Type::nonNull(Type::float()),
                    'description' => 'Total order amount',
                ],
            ],
        ]);
    }
}
