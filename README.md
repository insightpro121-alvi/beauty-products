# 💄 Beauty Haven - E-Commerce Beauty Products Website

A beautiful, responsive PHP-based e-commerce website for selling beauty products.

## Features

✨ **Modern Design**
- Beautiful gradient UI with smooth animations
- Fully responsive design (mobile, tablet, desktop)
- Professional styling with hover effects

🛍️ **Product Management**
- Product catalog with images, descriptions, and ratings
- Category-based filtering
- Dynamic product grid layout

🛒 **Shopping Cart**
- Add/remove products from cart
- Adjust quantities
- Local storage for persistent cart
- Real-time cart updates

📧 **Contact Form**
- Contact page for customer inquiries
- Email validation
- User-friendly messages

📱 **Responsive**
- Mobile-first design
- Optimized for all screen sizes
- Touch-friendly buttons and controls

## File Structure

```
beauty-products/
├── index.php          # Main product page
├── cart.php           # Shopping cart page
├── contact.php        # Contact form page
├── styles.css         # Main stylesheet
├── script.js          # JavaScript functionality
├── images/            # Product images folder
└── README.md          # This file
```

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/insightpro121-alvi/beauty-products.git
   cd beauty-products
   ```

2. **Set up a local server**
   - Using PHP built-in server:
     ```bash
     php -S localhost:8000
     ```
   - Or use Apache/Nginx with PHP support

3. **Add product images**
   - Create an `images/` folder in the root directory
   - Add your product images (e.g., `serum.jpg`, `facewash.jpg`, etc.)

4. **Open in browser**
   ```
   http://localhost:8000
   ```

## How to Use

### Add New Products
Edit `index.php` and add to the `$products` array:
```php
[
    'id' => 7,
    'name' => 'Product Name',
    'category' => 'Category',
    'price' => 29.99,
    'image' => 'images/product.jpg',
    'description' => 'Product description',
    'rating' => 4.5
]
```

### Customize Colors
Edit `styles.css` and change the gradient colors:
```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Shopping Cart Features
- Products are stored in browser's localStorage
- Persistent cart across page refreshes
- Automatic total calculation
- Quantity management

## Technologies Used

- **PHP 7.0+** - Backend logic
- **HTML5** - Structure
- **CSS3** - Styling with gradients and animations
- **JavaScript (Vanilla)** - Shopping cart functionality
- **LocalStorage** - Client-side data persistence

## Features Ready to Implement

- [ ] Database integration (MySQL)
- [ ] User authentication & accounts
- [ ] Payment gateway integration (Stripe, PayPal)
- [ ] Order management system
- [ ] Admin panel
- [ ] Product reviews & ratings
- [ ] Wishlist functionality
- [ ] Email notifications

## Customization Tips

1. **Logo**: Change the `💄` emoji in navbar
2. **Colors**: Modify the gradient in `styles.css`
3. **Products**: Edit the array in `index.php`
4. **Images**: Upload your own product images to `images/` folder
5. **Navigation**: Update links in navbar

## Browser Compatibility

- Chrome ✅
- Firefox ✅
- Safari ✅
- Edge ✅
- Mobile browsers ✅

## License

MIT License - Feel free to use this project for personal or commercial purposes.

## Support

For issues or questions, please open an issue on GitHub.

---

**Made with ❤️ for beauty lovers**