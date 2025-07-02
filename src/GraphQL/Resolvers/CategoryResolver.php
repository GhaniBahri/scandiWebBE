<?php

namespace App\GraphQL\Resolvers;

use App\Model\Category\Category;
use App\Helper\DbConnect;
use App\GraphQL\Types;

class CategoryResolver
{
    public static function getAllCategories(): array
    {
        $db = DbConnect::getConnection();
        $sql = "SELECT name FROM categories";

        $stmt = $db->query($sql);
        $categories = [];

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $categories[] = new Category($row['name']);
        }

        return $categories;
    }
}
