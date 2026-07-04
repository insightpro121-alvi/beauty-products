<?php
require_once 'config/database.php';
require_once 'config/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php?redirect=wishlist.php');
    exit();
}

$user = getCurrentUser();
$wishlistIds = $db->getUserWishlist($user['id']);

// Sample products (same as in index.php)
$products = [
    [
        'id' => 1,
        'name' => 'Vitamin C Face Serum',
        'category' => 'Serums',
        'price' => 29.99,
        'image' => 'images/serum.jpg',
        'description' => 'Glow Boosting Vitamin C Serum for radiant skin.',
        'rating' => 4.8
    ],
    [
        'id' => 2,
        'name' => 'Herbal Face Wash',
        'category' => 'Cleansers',
        'price' => 12.50,
        'image' => 'images/facewash.jpg',
        'description' => 'Gentle and natural cleanser for everyday use.',
        'rating' => 4.6
    ],
    [
        'id' => 3,
        'name' => 'Moisturizing Cream',
        'category' => 'Moisturizers',
        'price' => 34.99,
        'image' => 'images/cream.jpg',
        'description' => 'Rich cream for deep hydration and skin nourishment.',
        'rating' => 4.9
    ],
    [
        'id' => 4,
        'name' => 'Anti-Aging Eye Cream',
        'category' => 'Eye Care',
        'price' => 44.99,
        'image' => 'images/eyecream.jpg',
        'description' => 'Reduces fine lines and dark circles around eyes.',
        'rating' => 4.7
    ],
    [
        'id' => 5,
        'name' => 'Lip Balm SPF 30',
        'category' => 'Lip Care',
        'price' => 8.99,
        'image' => 'images/lipbalm.jpg',
        'description' => 'Protective and nourishing lip balm with SPF.',
        'rating' => 4.5
    ],
    [
        'id' => 6,
        'name' => 'Sheet Mask Pack',
        'category' => 'Masks',
        'price' => 15.99,
        'image' => 'images/mask.jpg',
        'description' => 'Hydrating sheet mask for instant glow.',
        'rating' => 4.4
    ]
];

// Filter wishlist products
$wishlistProducts = array_filter($products, function($p) use ($wishlistIds) {
    return in_array($p['id'], $wishlistIds);
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist - Beauty Haven</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .wishlist-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .wishlist-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .empty-wishlist {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 12px;
            color: #999;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .wishlist-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff6b9d;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            cursor: pointer;
            font-size: 1em;
        }

        .product-info {
            padding: 1.5rem;
        }

        .price {
            font-size: 1.5em;
            font-weight: bold;
            color: #ff6b9d;
            margin-bottom: 1rem;
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
        <div class="wishlist-header">
            <h1>❤️ My Wishlist</h1>
            <span style="color: #666;">(?= count($wishlistProducts) ?> items)</span>
        </div>

        <?php if (empty($wishlistProducts)): ?>
            <div class="empty-wishlist">
                <h2>Your wishlist is empty</h2>
                <p><a href="index.php#products" style="color: #667eea; text-decoration: none;">Start adding your favorite products</a></p>
            </div>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($wishlistProducts as $product): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            <button class="wishlist-btn" onclick="removeFromWishlist(<?= $product['id'] ?>)">Remove ❤️</button>
                        </div>
                        <div class="product-info">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p><?= htmlspecialchars($product['description']) ?></p>
                            <div class="price">$<?= number_format($product['price'], 2) ?></div>
                            <button class="btn-add-cart" onclick="addToCart(<?= $product['id'] ?>, '<?= addslashes($product['name']) ?>', <?= $product['price'] ?>)">Add to Cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Beauty Haven. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function removeFromWishlist(productId) {
            fetch('api/wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'remove',
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
        
        function addToCart(id, name, price) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let existingItem = cart.find(item => item.id === id);
            
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({id: id, name: name, price: price, quantity: 1});
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            alert(name + ' added to cart!');
        }
    </script>
</body>
</html>
