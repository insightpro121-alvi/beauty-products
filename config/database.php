<?php
// Database configuration
class Database {
    private $db;
    
    public function __construct() {
        $this->db = new SQLite3('beauty_store.db');
        $this->initializeTables();
    }
    
    private function initializeTables() {
        // Users table
        $this->db->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY,
            username TEXT UNIQUE,
            email TEXT UNIQUE,
            password TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Orders table
        $this->db->exec("CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY,
            user_id INTEGER,
            total_price REAL,
            status TEXT DEFAULT 'pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(user_id) REFERENCES users(id)
        )");
        
        // Order items table
        $this->db->exec("CREATE TABLE IF NOT EXISTS order_items (
            id INTEGER PRIMARY KEY,
            order_id INTEGER,
            product_id INTEGER,
            product_name TEXT,
            quantity INTEGER,
            price REAL,
            FOREIGN KEY(order_id) REFERENCES orders(id)
        )");
        
        // Reviews table
        $this->db->exec("CREATE TABLE IF NOT EXISTS reviews (
            id INTEGER PRIMARY KEY,
            product_id INTEGER,
            user_id INTEGER,
            rating INTEGER,
            comment TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Wishlist table
        $this->db->exec("CREATE TABLE IF NOT EXISTS wishlist (
            id INTEGER PRIMARY KEY,
            user_id INTEGER,
            product_id INTEGER,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(user_id, product_id),
            FOREIGN KEY(user_id) REFERENCES users(id)
        )");
    }
    
    public function getConnection() {
        return $this->db;
    }
    
    public function registerUser($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bindValue(1, $username, SQLITE3_TEXT);
        $stmt->bindValue(2, $email, SQLITE3_TEXT);
        $stmt->bindValue(3, $hashedPassword, SQLITE3_TEXT);
        
        return $stmt->execute() ? true : false;
    }
    
    public function loginUser($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bindValue(1, $username, SQLITE3_TEXT);
        $result = $stmt->execute();
        $user = $result->fetchArray(SQLITE3_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bindValue(1, $id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        return $result->fetchArray(SQLITE3_ASSOC);
    }
    
    public function addReview($productId, $userId, $rating, $comment) {
        $stmt = $this->db->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->bindValue(1, $productId, SQLITE3_INTEGER);
        $stmt->bindValue(2, $userId, SQLITE3_INTEGER);
        $stmt->bindValue(3, $rating, SQLITE3_INTEGER);
        $stmt->bindValue(4, $comment, SQLITE3_TEXT);
        
        return $stmt->execute() ? true : false;
    }
    
    public function getProductReviews($productId) {
        $stmt = $this->db->prepare("SELECT r.*, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = ? ORDER BY r.created_at DESC");
        $stmt->bindValue(1, $productId, SQLITE3_INTEGER);
        $result = $stmt->execute();
        
        $reviews = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $reviews[] = $row;
        }
        return $reviews;
    }
    
    public function addToWishlist($userId, $productId) {
        $stmt = $this->db->prepare("INSERT OR IGNORE INTO wishlist (user_id, product_id) VALUES (?, ?)");
        $stmt->bindValue(1, $userId, SQLITE3_INTEGER);
        $stmt->bindValue(2, $productId, SQLITE3_INTEGER);
        
        return $stmt->execute() ? true : false;
    }
    
    public function removeFromWishlist($userId, $productId) {
        $stmt = $this->db->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
        $stmt->bindValue(1, $userId, SQLITE3_INTEGER);
        $stmt->bindValue(2, $productId, SQLITE3_INTEGER);
        
        return $stmt->execute() ? true : false;
    }
    
    public function getUserWishlist($userId) {
        $stmt = $this->db->prepare("SELECT product_id FROM wishlist WHERE user_id = ?");
        $stmt->bindValue(1, $userId, SQLITE3_INTEGER);
        $result = $stmt->execute();
        
        $wishlist = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $wishlist[] = $row['product_id'];
        }
        return $wishlist;
    }
    
    public function createOrder($userId, $items, $totalPrice) {
        // Insert order
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
        $stmt->bindValue(1, $userId, SQLITE3_INTEGER);
        $stmt->bindValue(2, $totalPrice, SQLITE3_FLOAT);
        $stmt->execute();
        
        $orderId = $this->db->lastInsertRowID();
        
        // Insert order items
        foreach ($items as $item) {
            $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
            $stmt->bindValue(1, $orderId, SQLITE3_INTEGER);
            $stmt->bindValue(2, $item['id'], SQLITE3_INTEGER);
            $stmt->bindValue(3, $item['name'], SQLITE3_TEXT);
            $stmt->bindValue(4, $item['quantity'], SQLITE3_INTEGER);
            $stmt->bindValue(5, $item['price'], SQLITE3_FLOAT);
            $stmt->execute();
        }
        
        return $orderId;
    }
    
    public function getUserOrders($userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bindValue(1, $userId, SQLITE3_INTEGER);
        $result = $stmt->execute();
        
        $orders = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $orders[] = $row;
        }
        return $orders;
    }
    
    public function getOrderItems($orderId) {
        $stmt = $this->db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->bindValue(1, $orderId, SQLITE3_INTEGER);
        $result = $stmt->execute();
        
        $items = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $items[] = $row;
        }
        return $items;
    }
}

// Initialize database
$db = new Database();
?>
