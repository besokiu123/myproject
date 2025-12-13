<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    // Get cart items
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $items = [];
    foreach ($cart as $id => $item) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($product) {
            $items[] = [
                'id' => $id,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $item['quantity']
            ];
        }
    }
    echo json_encode($items);
} elseif ($method == 'POST') {
    // Add to cart
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $quantity = $data['quantity'] ?? 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$id] = ['quantity' => $quantity];
    }

    echo json_encode(['success' => true]);
} elseif ($method == 'PUT') {
    // Update cart
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $quantity = $data['quantity'];

    if (isset($_SESSION['cart'][$id])) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
        }
    }

    echo json_encode(['success' => true]);
} elseif ($method == 'DELETE') {
    // Remove from cart
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }

    echo json_encode(['success' => true]);
}