# Custom CSS & JS Files Guide

## Overview
This document explains the custom CSS and JavaScript files created for the PhamThiMy_MyWeb e-commerce project.

---

## 📁 File Structure

```
resources/
├── css/
│   ├── custom.css          # Main custom styles
│   └── components.css       # Component-specific styles
└── js/
    ├── custom.js           # Main utility functions
    ├── helpers.js          # Helper classes for Cart, Product, Filter, etc.
    ├── app.js              # Application entry point
    └── bootstrap.js        # Bootstrap initialization (axios setup)
```

---

## 🎨 CSS Files

### 1. **custom.css** - Main Stylesheet
Contains core styles for the entire application including:

#### Sections:
- **Variables & Root Styles**: CSS custom properties for colors, transitions
- **Typography**: Heading, paragraph, and link styles
- **Buttons**: Various button styles (.btn, .btn-primary, .btn-secondary, etc.)
- **Forms**: Form controls, inputs, labels, and validation styles
- **Cards**: Reusable card components
- **Alerts**: Success, danger, warning, info alerts
- **Tables**: Table styling with striped and hover effects
- **Pagination**: Pagination styling
- **Utilities**: Margin, padding, display utilities
- **Responsive**: Mobile-first responsive design

#### Color Variables:
```css
--primary-color: #4f46e5       /* Primary brand color */
--secondary-color: #06b6d4     /* Secondary brand color */
--success-color: #10b981       /* Success state */
--danger-color: #ef4444        /* Danger/error state */
--warning-color: #f59e0b       /* Warning state */
--dark-color: #1f2937          /* Dark text */
--light-color: #f3f4f6         /* Light background */
```

### 2. **components.css** - Component Styles
Specific styles for reusable components:

- **Navbar**: Navigation bar styling
- **Product Card**: Product listing card styles
- **Category**: Category component styles
- **Breadcrumb**: Navigation breadcrumb styles
- **Sidebar**: Sidebar container styles
- **Filter**: Product filter component styles
- **Modal**: Modal dialog styles
- **Toast Notification**: Toast message styles
- **Loading Spinner**: Loading animation
- **Cart**: Shopping cart item styles
- **Pagination**: Custom pagination styles

---

## 🚀 JavaScript Files

### 1. **custom.js** - Main Utility Functions

#### Utility Functions:
```javascript
showToast(message, type, duration)     // Show notification toast
showLoading(element)                   // Show loading state
hideLoading(element, text)             // Hide loading state
formatPrice(price)                     // Format price as currency
debounce(func, wait)                   // Debounce function
throttle(func, limit)                  // Throttle function
```

#### DOM Manipulation:
```javascript
toggleElement(selector)                // Toggle element visibility
addEventListeners(selector, event, cb) // Add event to multiple elements
```

#### Form Handling:
```javascript
clearForm(formId)                      // Clear all form inputs
displayFormErrors(errors, formId)      // Display validation errors
clearFormErrors(formId)                // Clear form errors
```

#### AJAX/Fetch Helpers:
```javascript
get(url)                               // GET request
post(url, data)                        // POST request
put(url, data)                         // PUT request
deleteRequest(url)                     // DELETE request
makeRequest(url, options)              // Generic fetch request
```

#### Validation:
```javascript
isValidEmail(email)                    // Email validation
isValidPhoneVN(phone)                  // Vietnam phone validation
isStrongPassword(password)             // Password strength check
```

### 2. **helpers.js** - Helper Classes

#### CartHelper
```javascript
CartHelper.addToCart(product)          // Add item to cart
CartHelper.removeFromCart(productId)   // Remove item
CartHelper.updateQuantity(id, qty)     // Update quantity
CartHelper.getCart()                   // Get all cart items
CartHelper.getTotal()                  // Calculate total price
CartHelper.getCount()                  // Get total quantity
CartHelper.clearCart()                 // Empty cart
CartHelper.updateUI()                  // Update cart UI badge
```

#### ProductHelper
```javascript
ProductHelper.formatProduct(product)   // Format product data
ProductHelper.validateProduct(product) // Validate product
ProductHelper.getRatingStars(rating)   // Get star rating display
```

#### FilterHelper
```javascript
FilterHelper.buildQueryString(filters) // Build query string
FilterHelper.parseQueryString(str)     // Parse query string
FilterHelper.applyFilters(items, f)    // Filter items
```

#### SearchHelper
```javascript
SearchHelper.search(items, keyword)    // Search by keyword
SearchHelper.highlightKeyword(text)    // Highlight matches
```

#### SortHelper
```javascript
SortHelper.sort(items, field, order)   // Generic sort
SortHelper.sortByPrice(items, order)   // Sort by price
SortHelper.sortByName(items, order)    // Sort by name
SortHelper.sortByRating(items, order)  // Sort by rating
```

#### PaginationHelper
```javascript
PaginationHelper.paginate(items, p, pp) // Paginate items
PaginationHelper.generateLinks(...)    // Generate pagination links
```

---

## 📚 Usage Examples

### Include in Blade Template
```blade
<!-- CSS Files -->
<link rel="stylesheet" href="{{ asset('resources/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('resources/css/components.css') }}">

<!-- JS Files -->
<script src="{{ asset('resources/js/custom.js') }}"></script>
<script src="{{ asset('resources/js/helpers.js') }}"></script>
```

### Using Button Styles
```html
<!-- Primary button -->
<button class="btn btn-primary">Click me</button>

<!-- Secondary button with size -->
<button class="btn btn-secondary btn-lg">Large Button</button>

<!-- Outline button -->
<button class="btn btn-outline btn-sm">Small Outline</button>
```

### Using Form Controls
```html
<form id="productForm">
    <div class="form-group">
        <label for="productName" class="form-label">Product Name</label>
        <input type="text" id="productName" name="name" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
```

### Using Toast Notifications
```javascript
// Success notification
showToast('Product added to cart!', 'success', 3000);

// Error notification
showToast('Error adding product', 'danger', 5000);
```

### Using Cart Helper
```javascript
// Add product to cart
const product = {
    id: 1,
    name: 'Product Name',
    price: 100000,
    quantity: 1,
    image: '/path/to/image.jpg'
};

CartHelper.addToCart(product);
CartHelper.updateUI(); // Update cart badge

// Get cart total
const total = CartHelper.getTotal();
console.log('Cart Total:', formatPrice(total));
```

### Using Product Filter & Sort
```javascript
// Search products
const keyword = 'laptop';
const results = SearchHelper.search(products, keyword, ['name', 'description']);

// Sort by price (ascending)
const sorted = SortHelper.sortByPrice(results, 'asc');

// Apply filters
const filters = { category: 'electronics', brand: 'Dell' };
const filtered = FilterHelper.applyFilters(sorted, filters);

// Paginate results
const page1 = PaginationHelper.paginate(filtered, 1, 10);
```

### Using AJAX Requests
```javascript
// GET request
get('/api/products')
    .then(response => {
        console.log('Products:', response.data);
    })
    .catch(error => {
        showToast('Error loading products', 'danger');
    });

// POST request
post('/api/cart/add', { product_id: 1, quantity: 2 })
    .then(response => {
        showToast('Added to cart', 'success');
        CartHelper.addToCart(response.data);
    })
    .catch(error => {
        displayFormErrors(error.response.data.errors, 'cartForm');
    });
```

---

## 🎯 Best Practices

1. **Use CSS Variables**: Utilize the defined CSS variables for consistency
2. **Follow BEM Naming**: Use Block Element Modifier for CSS class names
3. **Mobile First**: Responsive design starts from mobile
4. **Accessibility**: Use semantic HTML and proper ARIA labels
5. **Performance**: Use debounce/throttle for frequent events
6. **Error Handling**: Always handle API errors gracefully
7. **Validation**: Validate forms on both client and server side

---

## 📦 Customization

### Adding New Colors
Edit `custom.css`:
```css
:root {
    --your-color: #hexcode;
}
```

### Adding New Components
Create new file: `resources/css/my-component.css`

### Creating Reusable Modules
Edit `helpers.js` and add new helper class:
```javascript
const MyHelper = {
    myMethod: function() {
        // Implementation
    }
};
```

---

## 🔗 Dependencies

- **Bootstrap.js**: Axios HTTP client (Laravel default)
- **No external CSS frameworks**: Pure custom CSS
- **No jQuery**: Uses vanilla JavaScript

---

## 📱 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

---

## 🐛 Troubleshooting

### Styles not applying
1. Clear browser cache (Ctrl+Shift+Del)
2. Check file paths are correct
3. Verify CSS file is loaded in browser DevTools

### JavaScript errors
1. Check browser console (F12 → Console)
2. Verify file is included before use
3. Check for typos in function names

### CSRF Token errors
Ensure meta tag exists in layout:
```blade
<meta name="csrf-token" content="{{ csrf_token() }}">
```

---

## 📝 Notes

- All files follow modern JavaScript (ES6+) standards
- CSS uses mobile-first responsive design
- Modular structure allows easy extension
- Compatible with Laravel Blade templates

---

**Last Updated**: July 15, 2026
**Version**: 1.0.0
