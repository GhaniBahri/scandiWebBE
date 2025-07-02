<?php

namespace App\GraphQL\Resolvers;

use App\Model\Product\Product;
use App\Model\Product\ClothingProduct;
use App\Model\Product\TechProduct;
use App\Model\Category\Category;
use App\Model\Price\Price;
use App\Model\Currency\Currency;
use App\Model\Attribute\TextAttribute;
use App\Model\Attribute\SwatchAttribute;
use App\Model\AttributeOption;
use App\Helper\DbConnect;

class ProductResolver
{
    public static function getAllProducts(?string $category = null): array
    {
        $db = DbConnect::getConnection();

        $sql = "SELECT 
                    p.id, p.name, p.inStock, p.gallery, p.description, p.brand,
                    p.category_name
                FROM products p";

        $params = [];
        if ($category) {
            $sql .= " WHERE p.category_name = :category";
            $params[':category'] = $category;
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        $products = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $products[] = self::createProductFromDatabase($row);
        }

        return $products;
    }

    public static function getProductById(string $id): ?Product
    {
        $db = DbConnect::getConnection();
        $sql = "SELECT 
                    p.id, p.name, p.inStock, p.gallery, p.description, p.brand,
                    p.category_name
                FROM products p
                WHERE p.id = :id";

        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ? self::createProductFromDatabase($row) : null;
    }

    private static function createProductFromDatabase(array $row): Product
    {
        $category = new Category($row['category_name']);

        $gallery = json_decode($row['gallery'], true);

        $prices = self::getPricesForProduct($row['id']);

        $attributes = self::getAttributesForProduct($row['id']);

        if ($row['category_name'] === 'tech') {
            return new TechProduct(
                $row['id'],
                $row['name'],
                (bool)$row['inStock'],
                $gallery,
                $row['description'],
                $row['brand'],
                $prices,
                $attributes,
                $category
            );
        } else {
            return new ClothingProduct(
                $row['id'],
                $row['name'],
                (bool)$row['inStock'],
                $gallery,
                $row['description'],
                $row['brand'],
                $prices,
                $attributes,
                $category
            );
        }
    }

    private static function getPricesForProduct(string $productId): array
    {
        $db = DbConnect::getConnection();
        $sql = "SELECT p.amount, c.label, c.symbol
                FROM prices p
                JOIN currencies c ON p.currency_lbl = c.label
                WHERE p.product_id = :product_id";

        $stmt = $db->prepare($sql);
        $stmt->execute([':product_id' => $productId]);

        $prices = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $currency = new Currency($row['label'], $row['symbol']);
            $prices[] = new Price((float)$row['amount'], $currency);
        }

        return $prices;
    }

    private static function getAttributesForProduct(string $productId): array
    {
        $db = DbConnect::getConnection();
        $sql = "SELECT 
                    a.id, a.name, a.type,
                    i.id AS item_id, i.displayValue, i.value
                FROM product_attribute_items pai
                JOIN attributes a ON pai.attribute_id = a.id
                JOIN items i ON pai.attribute_id = i.attribute_id AND pai.item_id = i.id
                WHERE pai.product_id = :product_id";

        $stmt = $db->prepare($sql);
        $stmt->execute([':product_id' => $productId]);

        $attributes = [];
        $attributeMap = [];

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $attributeId = $row['id'];

            if (!isset($attributeMap[$attributeId])) {
                $attribute = $row['type'] === 'swatch'
                    ? new SwatchAttribute($attributeId, $row['name'])
                    : new TextAttribute($attributeId, $row['name']);

                $attributeMap[$attributeId] = $attribute;
                $attributes[] = $attribute;
            }

            $option = new AttributeOption(
                $row['item_id'],
                $row['displayValue'],
                $row['value']
            );

            $attributeMap[$attributeId]->addOption($option);
        }

        return $attributes;
    }
}
