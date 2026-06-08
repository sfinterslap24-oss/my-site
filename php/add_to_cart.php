<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'NOT_AUTH'
    ]);
    exit;
}

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$product_id = $data['product_id'] ?? 0;
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT quantity
    FROM cart
    WHERE user_id = ?
    AND product_id = ?
");

$stmt->execute([$user_id, $product_id]);

$item = $stmt->fetch();

if ($item) {

    $stmt = $pdo->prepare("
        UPDATE cart
        SET quantity = quantity + 1
        WHERE user_id = ?
        AND product_id = ?
    ");

    $stmt->execute([$user_id, $product_id]);

} else {

    $stmt = $pdo->prepare("
        INSERT INTO cart (
            user_id,
            product_id,
            quantity
        )
        VALUES (?, ?, 1)
    ");

    $stmt->execute([
        $user_id,
        $product_id
    ]);
}

echo json_encode([
    'status' => 'success'
]);