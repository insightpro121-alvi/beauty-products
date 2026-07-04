<?php
require_once 'config/database.php';
require_once 'config/auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if ($data['action'] == 'add_review') {
    $db->addReview($data['product_id'], $_SESSION['user_id'], $data['rating'], $data['comment']);
    echo json_encode(['success' => true]);
} elseif ($data['action'] == 'get_reviews') {
    $reviews = $db->getProductReviews($data['product_id']);
    echo json_encode(['success' => true, 'reviews' => $reviews]);
}
?>
