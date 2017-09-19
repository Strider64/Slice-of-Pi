<?php

use Library\Database\Database as DB;

function getUserInfo() {
    $db = DB::getInstance();
    $pdo = $db->getConnection(); // I am assuming you know how to write a PDO connection string:
    $query = 'SELECT id, username, full_name, security_level, private FROM users';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}
