<?php

declare (strict_types = 1);

namespace App\GraphQL\Types;

use App\Model\Product;
use App\Model\Category;
use App\GraphQL\Types\CategoryType;
use App\GraphQL\Types\AttributeType;
use App\GraphQL\Types\PriceType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class ProductType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Product',
            'description' => 'A product in the store',
            'fields' => fn(): array => [
                'id' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Unique product identifier',
                ],
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Product name',
                ],
                'inStock' => [
                    'type' => Type::nonNull(Type::boolean()),
                    'description' => 'Availability status',
                ],
                'gallery' => [
                    'type' => Type::listOf(Type::string()),
                    'description' => 'Product image URLs',
                ],
                'description' => [
                    'type' => Type::string(),
                    'description' => 'Product description',
                ],
                'brand' => [
                    'type' => Type::string(),
                    'description' => 'Product brand',
                ],
                'attributes' => [
                    'type' => Type::listOf(AttributeType::get()),
                    'description' => 'Product attributes',
                ],
                'prices' => [
                    'type' => Type::listOf(PriceType::get()),
                    'description' => 'Product prices in different currencies',
                ],
                'category' => [
                    'type' => CategoryType::get(),
                    'description' => 'Product category',
                ],
            ],
            'resolveField' => function(Product $product, array $args, $context, $info) {
                return match($info->fieldName) {
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'inStock' => $product->isInStock(),
                    'gallery' => $product->getGallery(),
                    'description' => $product->getDescription(),
                    'brand' => $product->getBrand(),
                    'attributes' => $product->getAttributes(),
                    'prices' => $product->getPrices(),
                    'category' => $product->getCategory(),
                    default => null
                };
            }
        ]);
    }

    public static function get(): self
    {
        static $type;
        return $type ??= new self();
    }
}