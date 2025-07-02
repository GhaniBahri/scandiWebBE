<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Model\Product\Product;
use App\Model\Product\ClothingProduct;
use App\Model\Product\TechProduct;
use App\GraphQL\Types;

class ProductType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Product',
            'description' => 'A product in the eCommerce store',
            'fields' => function () {
                return [
                    'id' => [
                        'type' => Type::nonNull(Type::id()),
                        'description' => 'Unique identifier of the product',
                    ],
                    'name' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'Name of the product',
                    ],
                    'inStock' => [
                        'type' => Type::nonNull(Type::boolean()),
                        'description' => 'Availability status of the product',
                    ],
                    'gallery' => [
                        'type' => Type::nonNull(Type::listOf(Type::string())),
                        'description' => 'List of image URLs for the product gallery',
                    ],
                    'description' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'HTML description of the product',
                    ],
                    'category' => [
                        'type' => Types::category(),
                        'description' => 'Category this product belongs to',
                    ],
                    'attributes' => [
                        'type' => Type::nonNull(Type::listOf(Types::attribute())),
                        'description' => 'Product attributes and options',
                    ],
                    'prices' => [
                        'type' => Type::nonNull(Type::listOf(Types::price())),
                        'description' => 'Pricing information in different currencies',
                    ],
                    'brand' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'Brand name of the product',
                    ],
                    'productType' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'Type of product (clothing or tech)',
                        'resolve' => function (Product $product) {
                            return $product->getProductType();
                        }
                    ]
                ];
            },
            'resolveField' => function (Product $product, $args, $context, $info) {
                $method = 'get' . ucfirst($info->fieldName);
                if (method_exists($product, $method)) {
                    return $product->$method();
                }
                return $product->{$info->fieldName};
            }
        ]);
    }
}
