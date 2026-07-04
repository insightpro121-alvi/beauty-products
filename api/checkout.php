<?php
require_once 'config/database.php';
require_once 'config/auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$user = getCurrentUser();
$data = json_decode(file_get_contents('php://input'), true);

if ($data['action'] == 'checkout') {
    $items = $data['items'];
    $totalPrice = 0;
    
    foreach ($items as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }
    
    $orderId = $db->createOrder($user['id'], $items, $totalPrice);
    echo json_encode(['success' => true, 'order_id' => $orderId]);
}
?>
