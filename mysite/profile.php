<?php
session_start();
require 'php/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = (int)$_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT user_id, name, email FROM users WHERE user_id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT
        order_id,
        total_amount
    FROM orders
    WHERE user_id = ?
    ORDER BY order_id DESC
");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$orderItems = [];

if ($orders) {
    $orderIds = array_column($orders, 'order_id');
    $placeholders = implode(',', array_fill(0, count($orderIds), '?'));

    $stmt = $pdo->prepare("
        SELECT
            oi.order_id,
            oi.quantity,
            oi.price,
            p.product_name
        FROM order_items oi
        JOIN products p
            ON oi.product_id = p.product_id
        WHERE oi.order_id IN ($placeholders)
        ORDER BY oi.order_id DESC
    ");
    $stmt->execute($orderIds);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
        $orderItems[$item['order_id']][] = $item;
    }
}

$name = htmlspecialchars((string)$user['name'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars((string)$user['email'], ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'php/header.php'; ?>

<main class="container profile-page">

    <section class="profile-hero">
        <div>
            <span class="profile-label">Личный кабинет</span>
            <h1><?= $name ?></h1>
            <p><?= $email ?></p>
        </div>

        <a class="profile-action" href="menu.php">Перейти в меню</a>
    </section>

    <section class="profile-grid">
        <div class="profile-card">
            <h2>Данные аккаунта</h2>

            <dl class="profile-info">
                <div>
                    <dt>Имя</dt>
                    <dd><?= $name ?></dd>
                </div>

                <div>
                    <dt>Email</dt>
                    <dd><?= $email ?></dd>
                </div>
            </dl>
        </div>

        <div class="profile-card profile-card-accent">
            <h2>Заказы</h2>
            <p>Всего заказов: <strong><?= count($orders) ?></strong></p>
            <p>Здесь сохраняется история оформленных заказов.</p>
        </div>
    </section>

    <section class="orders-section">
        <h2>История заказов</h2>

        <?php if (!$orders): ?>
            <div class="empty-orders">
                <h3>Заказов пока нет</h3>
                <p>Добавьте блюда в корзину и оформите первый заказ.</p>
                <a href="menu.php">Открыть меню</a>
            </div>
        <?php else: ?>
            <div class="orders-list">
                <?php foreach ($orders as $order): ?>
                    <?php $orderId = (int)$order['order_id']; ?>

                    <article class="order-card">
                        <div class="order-card-header">
                            <h3>Заказ #<?= $orderId ?></h3>
                            <strong><?= (float)$order['total_amount'] ?>₽</strong>
                        </div>

                        <?php if (!empty($orderItems[$orderId])): ?>
                            <ul class="order-items">
                                <?php foreach ($orderItems[$orderId] as $item): ?>
                                    <li>
                                        <span><?= htmlspecialchars((string)$item['product_name'], ENT_QUOTES, 'UTF-8') ?></span>
                                        <small>
                                            <?= (int)$item['quantity'] ?> шт. × <?= (float)$item['price'] ?>₽
                                        </small>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

</main>

<script src="js/scripts.js"></script>

</body>
</html>
