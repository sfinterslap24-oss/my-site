<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">

<?php include 'php/header.php'; ?>

<main class="container">
<div class="auth-wrapper">
    <div class="auth-box">

        <h2>Вход</h2>

        <form action="php/login.php" method="POST">

            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>

            <button type="submit">Войти</button>

        </form>

        <p>
            Нет аккаунта?
            <a href="register.php">Регистрация</a>
        </p>

    </div>
  </div>
</main>

<script src="js/scripts.js"></script>

</body>
</html>
