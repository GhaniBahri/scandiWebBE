<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Model\Category\Category;
use App\GraphQL\Types;

class CategoryType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Category',
            'description' => 'A product category',
            'fields' => [
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Name of the category',
                    'resolve' => function (Category $category) {
                        return $category->getName();
                    }
                ],
                'products' => [
                    'type' => Type::listOf(Types::product()),
                    'description' => 'Products in this category',
                    'resolve' => function (Category $category, $args, $context) {
                        return $context['productLoader']->load($category->getName());
                    }
                ]
            ]
        ]);
    }
}
