<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'php/header.php'; ?>

<main class="container">

    <div id="cart-container"></div>

    <div class="cart-summary">
        <h2 id="cart-total">Итого: 0₽</h2>
        <button onclick="makeOrder()">Оформить заказ</button>
    </div>

</main>

<script src="js/scripts.js"></script>

</body>
</html>
