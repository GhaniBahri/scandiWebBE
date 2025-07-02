<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Model\Order\Order;
use App\Model\Order\OrderItem;
use App\Helper\DbConnect;
use DateTime;
use Exception;
use PDO;
use PDOException;

class OrderResolver
{
    public static function createOrder(array $input): Order
    {
        $db = DbConnect::getConnection();
        $db->beginTransaction();

        try {
            $orderSql = <<<SQL
                INSERT INTO orders (total, currency, created_at)
                VALUES (:total, :currency, NOW())
            SQL;

            $orderStmt = $db->prepare($orderSql);
            $orderStmt->execute([
                ':total'    => $input['total'],
                ':currency' => $input['currency'],
            ]);

            $orderId = (int) $db->lastInsertId();

            $itemSql = <<<SQL
                INSERT INTO order_items (order_id, product_id, quantity, attributes, price)
                VALUES (:order_id, :product_id, :quantity, :attributes, :price)
            SQL;

            $itemStmt = $db->prepare($itemSql);

            foreach ($input['items'] as $item) {
                $itemStmt->execute([
                    ':order_id'   => $orderId,
                    ':product_id' => $item['productId'],
                    ':quantity'   => $item['quantity'],
                    ':attributes' => json_encode($item['attributes'], JSON_THROW_ON_ERROR),
                    ':price'      => $item['price'],
                ]);
            }

            $db->commit();

            return self::getOrderById($orderId);
        } catch (PDOException | Exception $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw $e;
        }
    }

    private static function getOrderById(int $id): Order
    {
        $db = DbConnect::getConnection();
        $sql = <<<SQL
            SELECT id, total, currency, created_at
            FROM orders
            WHERE id = :id
        SQL;

        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $orderData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! $orderData) {
            throw new Exception("Order with ID {$id} not found");
        }

        $itemsSql = <<<SQL
            SELECT order_id, product_id, quantity, attributes, price
            FROM order_items
            WHERE order_id = :order_id
        SQL;

        $itemsStmt = $db->prepare($itemsSql);
        $itemsStmt->execute([':order_id' => $id]);

        $items = [];

        while ($itemData = $itemsStmt->fetch(PDO::FETCH_ASSOC)) {
            $attributes = json_decode($itemData['attributes'], true, 512, JSON_THROW_ON_ERROR);

            $items[] = new OrderItem(
                (int) $itemData['order_id'],
                $itemData['product_id'],
                (int) $itemData['quantity'],
                $attributes,
                (float) $itemData['price']
            );
        }

        return new Order(
            (int) $orderData['id'],
            (float) $orderData['total'],
            $orderData['currency'],
            $items,
            new DateTime($orderData['created_at'])
        );
    }

    public static function getAllOrders(): array
    {
        $db = DbConnect::getConnection();

        $sql = <<<SQL
            SELECT id, total, currency, created_at
            FROM orders
            ORDER BY created_at DESC
        SQL;

        $stmt = $db->prepare($sql);
        $stmt->execute();

        $orders = [];
        while ($orderData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orderId = (int) $orderData['id'];

            $itemsSql = <<<SQL
                SELECT order_id, product_id, quantity, attributes, price
                FROM order_items
                WHERE order_id = :order_id
            SQL;

            $itemsStmt = $db->prepare($itemsSql);
            $itemsStmt->execute([':order_id' => $orderId]);

            $items = [];
            while ($itemData = $itemsStmt->fetch(PDO::FETCH_ASSOC)) {
                $attributes = json_decode($itemData['attributes'], true, 512, JSON_THROW_ON_ERROR);
                $items[] = new OrderItem(
                    (int) $itemData['order_id'],
                    $itemData['product_id'],
                    (int) $itemData['quantity'],
                    $attributes,
                    (float) $itemData['price']
                );
            }

            $orders[] = new Order(
                $orderId,
                (float) $orderData['total'],
                $orderData['currency'],
                $items,
                new DateTime($orderData['created_at'])
            );
        }

        return $orders;
    }
}
