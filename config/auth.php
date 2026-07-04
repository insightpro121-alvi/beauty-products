<?php
session_start();

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true;
}

// Redirect to login if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

// Get current user
function getCurrentUser() {
    if (isLoggedIn()) {
        global $db;
        return $db->getUserById($_SESSION['user_id']);
    }
    return null;
}

// Logout user
function logoutUser() {
    $_SESSION = [];
    session_destroy();
    header('Location: index.php');
    exit();
}

// Sanitize input
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
?>
