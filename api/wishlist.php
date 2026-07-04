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

if ($data['action'] == 'add') {
    $db->addToWishlist($user['id'], $data['product_id']);
    echo json_encode(['success' => true]);
} elseif ($data['action'] == 'remove') {
    $db->removeFromWishlist($user['id'], $data['product_id']);
    echo json_encode(['success' => true]);
}
?>
