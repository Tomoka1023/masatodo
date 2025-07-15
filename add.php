<?php
require_once 'auth.php';
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $task = trim($_POST['task']);
    $due_date = $_POST['due_date'] ?? null;

    if (!empty($task)) {
        $stmt = $pdo->prepare("INSERT INTO todos (task, due_date, user_id) VALUES (:task, :due_date, :user_id)");
        $stmt->bindValue(':task', $task, PDO::PARAM_STR);
        $stmt->bindValue(':due_date', $due_date ?: null, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
    }
}

header("Location: index.php");
exit;
?>