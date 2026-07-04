// Shopping Cart Functionality

function addToCart(id, name, price) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Check if item already exists in cart
    let existingItem = cart.find(item => item.id === id);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: id,
            name: name,
            price: price,
            quantity: 1
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    showNotification(`${name} added to cart!`);
    updateCartCount();
}

function removeFromCart(id) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
    updateCartCount();
}

function updateQuantity(id, quantity) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let item = cart.find(item => item.id === id);
    
    if (item) {
        if (quantity <= 0) {
            removeFromCart(id);
        } else {
            item.quantity = quantity;
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartDisplay();
        }
    }
}

function updateCartDisplay() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartContainer = document.getElementById('cart-items');
    let totalPrice = document.getElementById('total-price');
    
    if (!cartContainer) return;
    
    cartContainer.innerHTML = '';
    let total = 0;
    
    if (cart.length === 0) {
        cartContainer.innerHTML = '<p class="empty-cart">Your cart is empty</p>';
    } else {
        cart.forEach(item => {
            let itemTotal = item.price * item.quantity;
            total += itemTotal;
            
            let cartItemHTML = `
                <div class="cart-item">
                    <div class="item-details">
                        <h4>${item.name}</h4>
                        <p>$${item.price.toFixed(2)}</p>
                    </div>
                    <div class="quantity-control">
                        <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                        <input type="number" value="${item.quantity}" onchange="updateQuantity(${item.id}, parseInt(this.value))">
                        <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                    </div>
                    <div class="item-total">$${itemTotal.toFixed(2)}</div>
                    <button class="btn-remove" onclick="removeFromCart(${item.id})">Remove</button>
                </div>
            `;
            cartContainer.innerHTML += cartItemHTML;
        });
    }
    
    if (totalPrice) {
        totalPrice.textContent = `$${total.toFixed(2)}`;
    }
}

function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    let cartLink = document.querySelector('.cart-link');
    
    if (cartLink) {
        cartLink.dataset.count = totalItems;
    }
}

function showNotification(message) {
    let notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 2000);
}

function checkout() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }
    
    alert('Thank you for your purchase! Order will be processed soon.');
    localStorage.removeItem('cart');
    window.location.href = 'index.php';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    updateCartDisplay();
});

// Add notification styles
const style = document.createElement('style');
style.textContent = `
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #667eea;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transform: translateX(400px);
        transition: 0.3s;
        z-index: 1000;
    }
    
    .notification.show {
        opacity: 1;
        transform: translateX(0);
    }
`;
document.head.appendChild(style);