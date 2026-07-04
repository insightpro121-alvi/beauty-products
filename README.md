# 💄 Beauty Haven - Advanced E-Commerce Website

## 🆕 New Features Added!

### ✨ User Authentication
- User registration (signup.php)
- Secure login system
- Password hashing with bcrypt
- Session management

### ❤️ Wishlist System
- Add/remove products to wishlist
- Persistent wishlist storage in database
- Dedicated wishlist page
- Heart button on product cards

### 👤 User Profile
- View profile information
- Order history
- Account details

### 💾 Database Integration
- SQLite database (beauty_store.db)
- User management
- Order tracking
- Reviews system
- Wishlist storage

### 🛒 Advanced Shopping Cart
- Persistent cart storage
- Order creation and tracking
- Order history in profile
- Quantity management

### 🔍 Product Search
- Search by product name
- Search by description
- Category filtering
- Combined search + filter

### ⭐ Reviews & Ratings
- Product reviews (ready to implement)
- User ratings
- Review database storage

### 🔐 Security Features
- Password hashing
- SQL injection prevention
- XSS protection
- Session validation

## 📁 New File Structure

```
beauty-products/
├── config/
│   ├── database.php        # Database configuration
│   └── auth.php           # Authentication functions
├── api/
│   ├── wishlist.php       # Wishlist API endpoints
│   ├── reviews.php        # Reviews API endpoints
│   └── checkout.php       # Checkout API endpoints
├── index.php              # Main page with search
├── login.php              # Login page
├── signup.php             # Registration page
├── profile.php            # User profile & orders
├── wishlist.php           # Wishlist page
├── logout.php             # Logout functionality
├── cart.php               # Shopping cart
├── contact.php            # Contact form
├── styles.css             # Stylesheets
├── script.js              # JavaScript
├── beauty_store.db        # SQLite database (auto-created)
└── README.md              # Documentation
```

## 🚀 Getting Started

### Installation

1. **Clone & setup**
   ```bash
   git clone https://github.com/insightpro121-alvi/beauty-products.git
   cd beauty-products
   php -S localhost:8000
   ```

2. **Database Setup**
   - Database automatically creates on first run
   - Tables auto-generate for users, orders, reviews, wishlist

3. **Create Account**
   - Visit http://localhost:8000
   - Click "Sign Up"
   - Create your account

4. **Start Shopping**
   - Browse products
   - Add to wishlist
   - Place orders
   - View order history

## 📚 How to Use

### For Customers

**Registration & Login:**
- Sign up with username, email, password
- Login to access wishlist and order history
- Logout from profile page

**Shopping:**
- Search products by name
- Filter by category
- Add to cart or wishlist
- View wishlist with heart button
- Checkout cart

**Profile:**
- View member information
- Check order history
- Track order status
- View order details

### For Developers

**Database Queries:**
```php
// Add to wishlist
$db->addToWishlist($userId, $productId);

// Create order
$db->createOrder($userId, $items, $totalPrice);

// Get user orders
$db->getUserOrders($userId);

// Add review
$db->addReview($productId, $userId, $rating, $comment);
```

## 🔄 API Endpoints

### Wishlist API (`/api/wishlist.php`)
```json
// Add to wishlist
{"action": "add", "product_id": 1}

// Remove from wishlist
{"action": "remove", "product_id": 1}
```

### Reviews API (`/api/reviews.php`)
```json
// Add review
{"action": "add_review", "product_id": 1, "rating": 5, "comment": "Great product!"}

// Get reviews
{"action": "get_reviews", "product_id": 1}
```

### Checkout API (`/api/checkout.php`)
```json
{"action": "checkout", "items": [{...}]}
```

## 🛠️ Technologies

- **Backend:** PHP 7.0+
- **Database:** SQLite3
- **Frontend:** HTML5, CSS3, JavaScript
- **Security:** Password hashing, SQL prepared statements

## 📦 Database Tables

### users
- id (INTEGER PRIMARY KEY)
- username (TEXT UNIQUE)
- email (TEXT UNIQUE)
- password (TEXT)
- created_at (DATETIME)

### orders
- id (INTEGER PRIMARY KEY)
- user_id (INTEGER FOREIGN KEY)
- total_price (REAL)
- status (TEXT)
- created_at (DATETIME)

### order_items
- id (INTEGER PRIMARY KEY)
- order_id (FOREIGN KEY)
- product_id (INTEGER)
- product_name (TEXT)
- quantity (INTEGER)
- price (REAL)

### reviews
- id (INTEGER PRIMARY KEY)
- product_id (INTEGER)
- user_id (INTEGER FOREIGN KEY)
- rating (INTEGER)
- comment (TEXT)
- created_at (DATETIME)

### wishlist
- id (INTEGER PRIMARY KEY)
- user_id (INTEGER FOREIGN KEY)
- product_id (INTEGER)
- created_at (DATETIME)

## 🔒 Security Notes

✅ Password hashing with bcrypt
✅ Prepared SQL statements (prevent SQL injection)
✅ XSS protection with htmlspecialchars()
✅ Session-based authentication
✅ Input validation & sanitization

## 🚀 Future Enhancements

- [ ] Payment gateway integration (Stripe)
- [ ] Email notifications
- [ ] Admin dashboard
- [ ] Product reviews display
- [ ] Email verification
- [ ] Password reset
- [ ] Social login
- [ ] Product inventory management
- [ ] Discount codes
- [ ] Product recommendations

## 🤝 Support

For issues or questions, please open an issue on GitHub.

---

**Made with ❤️ for beauty lovers**