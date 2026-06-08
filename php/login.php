<?php
session_start();
include 'db.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Пользователь не найден");
}

if (!password_verify($password, $user['password'])) {
    die("Неверный пароль");
}

$_SESSION['user_id'] = $user['user_id'];
$_SESSION['name'] = $user['name'];

header("Location: ../index.php");
exit;