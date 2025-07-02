<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Types;

class OrderItemType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'OrderItem',
            'description' => 'An item within an order',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'Unique identifier of the order item',
                    'resolve' => function ($item) {
                        return $item->getId();
                    }
                ],
                'productId' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'ID of the ordered product',
                    'resolve' => function ($item) {
                        return $item->getProductId();
                    }
                ],
                'quantity' => [
                    'type' => Type::nonNull(Type::int()),
                    'description' => 'Quantity ordered',
                    'resolve' => function ($item) {
                        return $item->getQuantity();
                    }
                ],
                'attributes' => [
                    'type' => Type::nonNull(Type::listOf(Type::string())),
                    'description' => 'Selected attributes for this item',
                    'resolve' => function ($item) {
                        return $item->getAttributes();
                    }
                ],
                'price' => [
                    'type' => Type::nonNull(Type::float()),
                    'description' => 'Price per unit',
                    'resolve' => function ($item) {
                        return $item->getPrice();
                    }
                ],
                'totalPrice' => [
                    'type' => Type::nonNull(Type::float()),
                    'description' => 'Total price for this item (price × quantity)',
                    'resolve' => function ($item) {
                        return $item->getTotalPrice();
                    }
                ]
            ]
        ]);
    }
}
