<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Beauty Haven</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .cart-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }

        .cart-items {
            margin-bottom: 2rem;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            gap: 1rem;
        }

        .item-details {
            flex: 1;
        }

        .item-details h4 {
            margin: 0 0 0.5rem 0;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-control button {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
            border-radius: 4px;
            font-size: 1em;
        }

        .quantity-control input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 0.5rem;
            border-radius: 4px;
        }

        .item-total {
            min-width: 100px;
            text-align: right;
            font-weight: bold;
            color: #ff6b9d;
        }

        .btn-remove {
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-remove:hover {
            background: #ff5252;
        }

        .cart-summary {
            background: #f9f9f9;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 1.1em;
        }

        .summary-row.total {
            border-top: 2px solid #ddd;
            padding-top: 1rem;
            font-weight: bold;
            color: #ff6b9d;
            font-size: 1.3em;
        }

        .empty-cart {
            text-align: center;
            padding: 3rem;
            color: #999;
        }

        .cart-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .cart-actions .btn-primary {
            padding: 1rem 2rem;
            font-size: 1em;
        }

        .btn-continue {
            background: #667eea;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-continue:hover {
            background: #764ba2;
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
                <li><a href="index.php#products">Products</a></li>
                <li><a href="index.php#about">About</a></li>
                <li><a href="index.php#contact">Contact</a></li>
                <li class="cart-link"><a href="cart.php">🛒 Cart</a></li>
            </ul>
        </div>
    </nav>

    <!-- Cart Container -->
    <div class="container">
        <div class="cart-container">
            <div class="cart-header">
                <h1>Shopping Cart</h1>
                <a href="index.php#products" class="btn-continue">Continue Shopping</a>
            </div>

            <div class="cart-items" id="cart-items">
                <!-- Cart items will be loaded here by JavaScript -->
            </div>

            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span id="total-price">$0.00</span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span>Free</span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span id="total-price">$0.00</span>
                </div>
            </div>

            <div class="cart-actions">
                <a href="index.php#products" class="btn-continue">Continue Shopping</a>
                <button class="btn-primary" onclick="checkout()">Checkout</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Beauty Haven. All rights reserved.</p>
            <p>Made with ❤️ for beauty lovers</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>