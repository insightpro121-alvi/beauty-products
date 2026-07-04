<?php
require_once 'config/database.php';
require_once 'config/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php?redirect=profile.php');
    exit();
}

$user = getCurrentUser();
$orders = $db->getUserOrders($user['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Beauty Haven</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .profile-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .profile-header {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-header h1 {
            margin-bottom: 1rem;
        }

        .profile-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .info-item {
            padding: 1rem;
            background: #f9f9f9;
            border-radius: 8px;
        }

        .info-label {
            color: #666;
            font-size: 0.9em;
        }

        .info-value {
            font-weight: bold;
            color: #333;
            margin-top: 0.5rem;
        }

        .orders-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .order-card {
            padding: 1.5rem;
            border: 1px solid #eee;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .order-status {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: bold;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .no-orders {
            text-align: center;
            color: #999;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">💄 Beauty Haven</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php#products">Products</a></li>
                <li><a href="wishlist.php">❤️ Wishlist</a></li>
                <li><a href="profile.php">👤 Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="profile-header">
            <h1>👤 My Profile</h1>
            <div class="profile-info">
                <div class="info-item">
                    <div class="info-label">Username</div>
                    <div class="info-value"><?= htmlspecialchars($user['username']) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value"><?= htmlspecialchars($user['email']) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Member Since</div>
                    <div class="info-value"><?= date('M d, Y', strtotime($user['created_at'])) ?></div>
                </div>
            </div>
        </div>

        <div class="orders-section">
            <h2>📦 Order History</h2>
            
            <?php if (empty($orders)): ?>
                <div class="no-orders">
                    <p>No orders yet. <a href="index.php#products">Start shopping</a></p>
                </div>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <strong>Order #<?= $order['id'] ?></strong>
                                <div style="color: #666; font-size: 0.9em;"><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></div>
                            </div>
                            <div style="text-align: right;">
                                <span class="order-status <?= $order['status'] == 'pending' ? 'status-pending' : 'status-completed' ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                                <div style="font-size: 1.2em; font-weight: bold; color: #ff6b9d; margin-top: 0.5rem;">
                                    $<?= number_format($order['total_price'], 2) ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php 
                        $items = $db->getOrderItems($order['id']);
                        ?>
                        <div style="padding: 1rem 0; border-top: 1px solid #eee;">
                            <?php foreach ($items as $item): ?>
                                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                                    <span><?= htmlspecialchars($item['product_name']) ?> x<?= $item['quantity'] ?></span>
                                    <span>$<?= number_format($item['price'], 2) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Beauty Haven. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
