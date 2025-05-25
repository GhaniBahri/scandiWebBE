<?php

function dbConnect()
{
    try {
        $pdo = new PDO(DB_SERVER, DB_USER, DB_PASS);
        return $pdo;
    } catch (Exception $error) {
        die("Connection failed: " . $error->getMessage());
    }
}
