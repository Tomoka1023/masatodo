<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)$_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

header("Location: index.php");
exit;
?>