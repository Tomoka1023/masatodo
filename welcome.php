<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // ログイン中なら ToDoリスト画面へジャンプ
    header("Location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ToDoアプリまさ坊</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
    <style>
        .welcome {
            text-align: center;
            margin-top: 100px;
        }

        .welcome h1 {
            font-size: 2em;
            color: #f1f3fa;
        }

        .welcome p {
            font-size: 1.1em;
            margin-bottom: 30px;
        }

        .welcome a {
            display: inline-block;
            background: linear-gradient(135deg, #3a0ca3, #7209b7, #4361ee);
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 0 10px #7209b7;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .welcome a:hover {
            box-shadow: 0 0 15px #4cc9f0;
        }
    </style>
</head>
<body>
    <div class="welcome">
        <h1>📝 ようこそ ToDoアプリまさ坊へ！</h1>
        <p>タスク管理で毎日をもっとスムーズに！</p>
        <a href="login.php">ログイン</a>
        <a href="register.php">新規登録</a>
    </div>
</body>
</html>
