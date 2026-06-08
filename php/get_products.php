<?php
include 'db.php';

header('Content-Type: application/json');

$stmt = $pdo->prepare("SELECT * FROM products WHERE available = 1");
$stmt->execute();

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));