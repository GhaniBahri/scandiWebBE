<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Input;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class OrderItemInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'OrderItemInput',
            'description' => 'Details for a single item in an order',
            'fields' => [
                'productId'  => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'ID of the product',
                ],
                'quantity'   => [
                    'type' => Type::nonNull(Type::int()),
                    'description' => 'Quantity of this product in the order',
                ],
                'attributes' => [
                    'type' => Type::nonNull(Type::listOf(Type::string())),
                    'description' => 'Selected attribute values (e.g., size:40)',
                ],
                'price'      => [
                    'type' => Type::nonNull(Type::float()),
                    'description' => 'Price per unit of this product',
                ],
            ],
        ]);
    }
}
