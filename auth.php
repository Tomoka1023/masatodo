<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // ログインしてない場合はログインページへリダイレクト
    header("Location: login.php");
    exit;
}
?>