<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        'status' => 'error'
    ]);

    exit;
}

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$product_id = $data['product_id'] ?? 0;
$action = $data['action'] ?? '';

$user_id = $_SESSION['user_id'];

if (!$product_id) {

    echo json_encode([
        'status' => 'error'
    ]);

    exit;
}

if ($action === 'increase') {

    $stmt = $pdo->prepare("
        UPDATE cart
        SET quantity = quantity + 1
        WHERE user_id = ?
        AND product_id = ?
    ");

    $stmt->execute([
        $user_id,
        $product_id
    ]);
}

if ($action === 'decrease') {

    $stmt = $pdo->prepare("
        SELECT quantity
        FROM cart
        WHERE user_id = ?
        AND product_id = ?
    ");

    $stmt->execute([
        $user_id,
        $product_id
    ]);

    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {

        if ($item['quantity'] <= 1) {

            $stmt = $pdo->prepare("
                DELETE FROM cart
                WHERE user_id = ?
                AND product_id = ?
            ");

            $stmt->execute([
                $user_id,
                $product_id
            ]);

        } else {

            $stmt = $pdo->prepare("
                UPDATE cart
                SET quantity = quantity - 1
                WHERE user_id = ?
                AND product_id = ?
            ");

            $stmt->execute([
                $user_id,
                $product_id
            ]);
        }
    }
}

echo json_encode([
    'status' => 'success'
]);