<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">

<?php include 'php/header.php'; ?>

<main class="container">
<div class="auth-wrapper">
    <div class="auth-box">

        <h2>Регистрация</h2>

        <form action="php/register.php" method="POST">

            <input type="text" name="name" placeholder="Имя" required>
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>

            <button type="submit">Создать аккаунт</button>

        </form>

        <p>
            Уже есть аккаунт?
            <a href="login.php">Войти</a>
        </p>

    </div>
</div>
</main>

<script src="js/scripts.js"></script>

</body>
</html>
