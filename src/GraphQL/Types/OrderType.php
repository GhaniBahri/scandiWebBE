<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Types as AppTypes;

class OrderType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Order',
            'description' => 'A placed order',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'Unique identifier of the order',
                    'resolve' => function ($order) {
                        return $order->getId();
                    }
                ],
                'total' => [
                    'type' => Type::nonNull(Type::float()),
                    'description' => 'Total amount of the order',
                    'resolve' => function ($order) {
                        return $order->getTotal();
                    }
                ],
                'currency' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Currency code for the order (e.g., USD)',
                    'resolve' => function ($order) {
                        return $order->getCurrency();
                    }
                ],
                'items' => [
                    'type' => Type::nonNull(Type::listOf(AppTypes::orderItem())),
                    'description' => 'Items included in the order',
                    'resolve' => function ($order) {
                        return $order->getItems();
                    }
                ],
                'createdAt' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Timestamp of when the order was placed',
                    'resolve' => function ($order) {
                        return $order->getFormattedCreatedAt();
                    }
                ]
            ]
        ]);
    }
}
