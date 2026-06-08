<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "status" => "error",
        "message" => "NOT_AUTH"
    ]);

    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT 
        c.product_id,
        c.quantity,
        p.price
    FROM cart c
    JOIN products p
        ON c.product_id = p.product_id
    WHERE c.user_id = ?
");

$stmt->execute([$user_id]);

$cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cart)) {

    echo json_encode([
        "status" => "error",
        "message" => "EMPTY_CART"
    ]);

    exit;
}

$total = 0;

foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

$stmt = $pdo->prepare("
    INSERT INTO orders (
        user_id,
        total_amount
    )
    VALUES (?, ?)
");

$stmt->execute([
    $user_id,
    $total
]);

$order_id = $pdo->lastInsertId();

foreach ($cart as $item) {

    $stmt = $pdo->prepare("
        INSERT INTO order_items (
            order_id,
            product_id,
            quantity,
            price
        )
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $order_id,
        $item['product_id'],
        $item['quantity'],
        $item['price']
    ]);
}

$stmt = $pdo->prepare("
    DELETE FROM cart
    WHERE user_id = ?
");

$stmt->execute([$user_id]);

echo json_encode([
    "status" => "success",
    "order_id" => $order_id
]);