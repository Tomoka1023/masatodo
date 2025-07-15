<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)$_POST['id'];

    // 今の状態を取得
    $stmt = $pdo->prepare("SELECT is_done FROM todos WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $todo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($todo) {
        // 状態を反転（1→0 または 0→1）
        $newStatus = $todo['is_done'] ? 0 : 1;

        $update = $pdo->prepare("UPDATE todos SET is_done = :status WHERE id = :id");
        $update->bindValue(':status', $newStatus, PDO::PARAM_INT);
        $update->bindValue(':id', $id, PDO::PARAM_INT);
        $update->execute();
    }
}

header("Location: index.php");
exit;
