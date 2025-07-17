<?php
// db.php

$dsn = 'mysql:host=localhost;dbname=xs279861_todomasa;charset=utf8mb4';
$user = 'xs279861_masabou';
$password = 'masabouadmin';

try {
    $pdo = new PDO($dsn, $user, $password);
    // エラーを例外として投げる
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // 接続確認
    // echo "DB接続成功";
} catch (PDOException $e) {
    echo "DB接続エラー: " . $e->getMessage();
    exit;
}
?>
