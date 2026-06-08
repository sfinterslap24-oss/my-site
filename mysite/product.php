<?php
session_start();
include 'php/db.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Товар не найден");
}

$productName = htmlspecialchars((string)($product['product_name'] ?? ''), ENT_QUOTES, 'UTF-8');
$description = htmlspecialchars((string)($product['description'] ?? ''), ENT_QUOTES, 'UTF-8');
$imageUrl = htmlspecialchars((string)($product['image_url'] ?? ''), ENT_QUOTES, 'UTF-8');
$price = (float)$product['price'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $productName ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'php/header.php'; ?>

<main class="container">

<h1><?= $productName ?></h1>

<img src="images/<?= $imageUrl ?>" alt="<?= $productName ?>" width="200">

<p><?= $description ?></p>
<p>Цена: <?= $price ?>₽</p>

<button onclick="addToCart(<?= (int)$product['product_id'] ?>)">
    Добавить в корзину
</button>

</main>

<script src="js/scripts.js"></script>

</body>
</html>
