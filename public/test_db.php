<?php
require_once __DIR__ . '/../src/Helper/DbConnect.php';

use App\Helper\DbConnect;

try {
    $db = DbConnect::getConnection();
    echo "DB OK";
} catch (PDOException $e) {
    echo "DB FAIL: " . $e->getMessage();
}
