<?php

namespace App\GraphQL;

use App\GraphQL\Types\ProductType;
use App\GraphQL\Types\CategoryType;
use App\GraphQL\Types\PriceType;
use App\GraphQL\Types\OrderType;
use App\GraphQL\Types\OrderItemType;
use App\GraphQL\Types\CurrencyType;
use App\GraphQL\Types\AttributeType;
use App\GraphQL\Types\AttributeOptionType;
use App\GraphQL\Types\Input\OrderInputType;

class Types
{
    private static $product;
    private static $category;
    private static $price;
    private static $currency;
    private static $attribute;
    private static $attributeOption;
    private static $query;
    private static $mutation;
    private static $order;
    private static $orderItem;
    private static $orderInput;

    public static function product(): ProductType
    {
        return self::$product ?: (self::$product = new ProductType());
    }

    public static function category(): CategoryType
    {
        return self::$category ?: (self::$category = new CategoryType());
    }

    public static function price(): PriceType
    {
        return self::$price ?: (self::$price = new PriceType());
    }

    public static function currency(): CurrencyType
    {
        return self::$currency ?: (self::$currency = new CurrencyType());
    }

    public static function attribute(): AttributeType
    {
        return self::$attribute ?: (self::$attribute = new AttributeType());
    }

    public static function attributeOption(): AttributeOptionType
    {
        return self::$attributeOption ?: (self::$attributeOption = new AttributeOptionType());
    }
    public static function query(): QueryType
    {
        return self::$query ?: (self::$query = QueryType::get());
    }

    public static function mutation(): MutationType
    {
        return self::$mutation ?: (self::$mutation = MutationType::get());
    }

    public static function order(): OrderType
    {
        return self::$order ?: (self::$order = new OrderType());
    }

    public static function orderItem(): OrderItemType
    {
        return self::$orderItem ?: (self::$orderItem = new OrderItemType());
    }

    public static function orderInput(): OrderInputType
    {
        return self::$orderInput ?: (self::$orderInput = new OrderInputType());
    }

}
