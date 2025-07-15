<?php
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'ユーザー名とパスワードを入力してください';
    } else {
        // 重複チェック
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindValue(':username', $username);
        $stmt->execute();

        if ($stmt->fetch()) {
            $error = 'そのユーザー名はすでに使われています';
        } else {
            // パスワードをハッシュ化
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // ユーザー登録
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':password', $hashedPassword);
            $stmt->execute();

            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
    <title>ユーザー登録</title>
</head>
<body>
    <h1>🆕 ユーザー登録</h1>
    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="ユーザー名" required><br>
        <input type="password" name="password" placeholder="パスワード" required><br>
        <button type="submit">登録</button>
    </form>
    <p>すでに登録済み？ <a href="login.php">ログインはこちら</a></p>
</body>
</html>
