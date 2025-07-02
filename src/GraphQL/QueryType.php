<?php

namespace App\GraphQL;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Types;
use App\GraphQL\Resolvers\ProductResolver;
use App\GraphQL\Resolvers\CategoryResolver;
use App\GraphQL\Resolvers\OrderResolver;

class QueryType extends ObjectType
{
    public static function get(): self
    {
        return new self([
            'name' => 'Query',
            'fields' => [
                'products' => [
                    'type' => Type::listOf(Types::product()),
                    'description' => 'Get all products',
                    'args' => [
                        'category' => [
                            'type' => Type::string(),
                            'description' => 'Filter by category name'
                        ]
                    ],
                    'resolve' => function ($root, $args) {
                        return ProductResolver::getAllProducts($args['category'] ?? null);
                    }
                ],
                'product' => [
                    'type' => Types::product(),
                    'description' => 'Get a product by ID',
                    'args' => [
                        'id' => [
                            'type' => Type::nonNull(Type::id()),
                            'description' => 'Product ID'
                        ]
                    ],
                    'resolve' => function ($root, $args) {
                        return ProductResolver::getProductById($args['id']);
                    }
                ],
                'categories' => [
                    'type' => Type::listOf(Types::category()),
                    'description' => 'Get all categories',
                    'resolve' => function () {
                        return CategoryResolver::getAllCategories();
                    }
                ],
                'orders' => [
                    'type' => Type::listOf(Types::order()),
                    'description' => 'Get all orders',
                    'resolve' => function () {
                        return OrderResolver::getAllOrders();
                    },
                ],
            ]
        ]);
    }
}
