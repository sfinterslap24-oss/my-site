<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT 
        c.product_id,
        c.quantity,
        p.product_name,
        p.price,
        p.image_url
    FROM cart c
    JOIN products p 
        ON c.product_id = p.product_id
    WHERE c.user_id = ?
");

$stmt->execute([$user_id]);

echo json_encode(
    $stmt->fetchAll(PDO::FETCH_ASSOC)
);