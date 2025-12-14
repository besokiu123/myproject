<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $cart = $_SESSION['cart'] ?? [];
    $items = [];

    foreach ($cart as $id => $item) {
        $stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $items[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $item['quantity']
            ];
        }
    }

    echo json_encode($items);
    exit;
}
