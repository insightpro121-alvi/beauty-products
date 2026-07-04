<?php
require_once 'config/database.php';
require_once 'config/auth.php';

// Beauty Products Database
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

// Get search query
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$selected_category = isset($_GET['category']) ? $_GET['category'] : 'All';

// Filter products
$filtered_products = $products;

if (!empty($search)) {
    $filtered_products = array_filter($filtered_products, function($p) use ($search) {
        return stripos($p['name'], $search) !== false || stripos($p['description'], $search) !== false;
    });
}

if ($selected_category !== 'All') {
    $filtered_products = array_filter($filtered_products, function($p) use ($selected_category) {
        return $p['category'] === $selected_category;
    });
}

$categories = array_unique(array_column($products, 'category'));
$user = isLoggedIn() ? getCurrentUser() : null;
$wishlistIds = isLoggedIn() ? $db->getUserWishlist($user['id']) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beauty Haven - Premium Beauty Products</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .search-bar {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .search-bar input {
            flex: 1;
            padding: 0.8rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
        }

        .search-bar button {
            padding: 0.8rem 1.5rem;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .product-card {
            position: relative;
        }

        .wishlist-heart {
            position: absolute;
            top: 10px;
            right: 10px;
            background: white;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">💄 Beauty Haven</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="wishlist.php">❤️ Wishlist</a></li>
                    <li><a href="profile.php">👤 <?= htmlspecialchars($user['username']) ?></a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">Sign Up</a></li>
                <?php endif; ?>
                <li class="cart-link"><a href="cart.php">🛒 Cart</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Beauty Haven</h1>
            <p>Discover Premium Beauty Products for Your Skin</p>
            <button class="btn-primary" onclick="document.getElementById('products').scrollIntoView({behavior: 'smooth'})">Shop Now</button>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products" id="products">
        <div class="container">
            <h2>Our Products</h2>
            
            <!-- Search Bar -->
            <form method="GET" class="search-bar">
                <input type="text" name="search" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Search</button>
            </form>
            
            <!-- Category Filter -->
            <div class="filter-section">
                <a href="index.php?search=<?= urlencode($search) ?>&category=All" class="filter-btn <?= $selected_category === 'All' ? 'active' : '' ?>">All Products</a>
                <?php foreach($categories as $cat): ?>
                    <a href="index.php?search=<?= urlencode($search) ?>&category=<?= urlencode($cat) ?>" class="filter-btn <?= $selected_category === $cat ? 'active' : '' ?>"><?= htmlspecialchars($cat) ?></a>
                <?php endforeach; ?>
            </div>

            <!-- Products Grid -->
            <div class="products-grid">
                <?php foreach($filtered_products as $product): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            <span class="category-badge"><?= htmlspecialchars($product['category']) ?></span>
                            <?php if (isLoggedIn()): ?>
                                <button class="wishlist-heart" onclick="toggleWishlist(<?= $product['id'] ?>)">
                                    <?= in_array($product['id'], $wishlistIds) ? '❤️' : '🤍' ?>
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="description"><?= htmlspecialchars($product['description']) ?></p>
                            <div class="rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-value"><?= $product['rating'] ?></span>
                            </div>
                            <div class="product-footer">
                                <span class="price">$<?= number_format($product['price'], 2) ?></span>
                                <button class="btn-add-cart" onclick="addToCart(<?= $product['id'] ?>, '<?= addslashes($product['name']) ?>', <?= $product['price'] ?>)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if(empty($filtered_products)): ?>
                <p class="no-products">No products found. Try a different search or category.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <h2>About Beauty Haven</h2>
            <p>We provide premium, authentic beauty products sourced from trusted brands around the world. Our mission is to help you discover products that enhance your natural beauty while maintaining the highest quality standards.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <h2>Get in Touch</h2>
            <form class="contact-form" method="POST" action="contact.php">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                <button type="submit" class="btn-primary">Send Message</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Beauty Haven. All rights reserved.</p>
            <p>Made with ❤️ for beauty lovers</p>
        </div>
    </footer>

    <script src="script.js"></script>
    <script>
        function toggleWishlist(productId) {
            fetch('api/wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'add',
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
    </script>
</body>
</html>