/**
 * ============================================
 * CART UTILITIES
 * Shopping cart management functions
 * ============================================
 */

const CartHelper = {
    /**
     * Add item to cart (localStorage)
     */
    addToCart: function(product) {
        let cart = this.getCart();
        const existingItem = cart.find(item => item.id === product.id);

        if (existingItem) {
            existingItem.quantity += product.quantity || 1;
        } else {
            cart.push({
                ...product,
                quantity: product.quantity || 1,
            });
        }

        this.saveCart(cart);
        return cart;
    },

    /**
     * Remove item from cart
     */
    removeFromCart: function(productId) {
        let cart = this.getCart();
        cart = cart.filter(item => item.id !== productId);
        this.saveCart(cart);
        return cart;
    },

    /**
     * Update item quantity
     */
    updateQuantity: function(productId, quantity) {
        let cart = this.getCart();
        const item = cart.find(item => item.id === productId);

        if (item) {
            if (quantity <= 0) {
                return this.removeFromCart(productId);
            }
            item.quantity = quantity;
        }

        this.saveCart(cart);
        return cart;
    },

    /**
     * Get cart
     */
    getCart: function() {
        const cart = localStorage.getItem('cart');
        return cart ? JSON.parse(cart) : [];
    },

    /**
     * Save cart to localStorage
     */
    saveCart: function(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
    },

    /**
     * Clear cart
     */
    clearCart: function() {
        localStorage.removeItem('cart');
    },

    /**
     * Get cart total
     */
    getTotal: function() {
        const cart = this.getCart();
        return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    },

    /**
     * Get cart count
     */
    getCount: function() {
        const cart = this.getCart();
        return cart.reduce((count, item) => count + item.quantity, 0);
    },

    /**
     * Update cart UI
     */
    updateUI: function() {
        const count = this.getCount();
        const cartBadge = document.querySelector('.cart-badge');
        if (cartBadge) {
            cartBadge.textContent = count;
            cartBadge.style.display = count > 0 ? 'block' : 'none';
        }
    },
};

// ============================================
// PRODUCT UTILITIES
// ============================================

const ProductHelper = {
    /**
     * Format product data
     */
    formatProduct: function(product) {
        return {
            id: product.id,
            name: product.name || product.title,
            price: parseFloat(product.price),
            image: product.image || product.thumbnail,
            description: product.description || '',
            category: product.category || '',
            rating: product.rating || 0,
        };
    },

    /**
     * Validate product
     */
    validateProduct: function(product) {
        const errors = {};

        if (!product.name || product.name.trim() === '') {
            errors.name = 'Product name is required';
        }

        if (!product.price || parseFloat(product.price) <= 0) {
            errors.price = 'Valid price is required';
        }

        if (!product.category) {
            errors.category = 'Category is required';
        }

        return {
            isValid: Object.keys(errors).length === 0,
            errors,
        };
    },

    /**
     * Get product rating stars
     */
    getRatingStars: function(rating) {
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 !== 0;
        let stars = '';

        for (let i = 0; i < 5; i++) {
            if (i < fullStars) {
                stars += '★';
            } else if (i === fullStars && hasHalfStar) {
                stars += '½';
            } else {
                stars += '☆';
            }
        }

        return stars;
    },
};

// ============================================
// FILTER UTILITIES
// ============================================

const FilterHelper = {
    /**
     * Build filter query string
     */
    buildQueryString: function(filters) {
        const params = new URLSearchParams();

        Object.keys(filters).forEach(key => {
            if (Array.isArray(filters[key])) {
                filters[key].forEach(value => {
                    params.append(key + '[]', value);
                });
            } else if (filters[key]) {
                params.set(key, filters[key]);
            }
        });

        return params.toString();
    },

    /**
     * Parse query string to filters
     */
    parseQueryString: function(queryString) {
        const params = new URLSearchParams(queryString);
        const filters = {};

        for (const [key, value] of params) {
            if (key.endsWith('[]')) {
                const baseKey = key.slice(0, -2);
                if (!filters[baseKey]) {
                    filters[baseKey] = [];
                }
                filters[baseKey].push(value);
            } else {
                filters[key] = value;
            }
        }

        return filters;
    },

    /**
     * Apply filters
     */
    applyFilters: function(items, filters) {
        return items.filter(item => {
            for (const [key, value] of Object.entries(filters)) {
                if (Array.isArray(value)) {
                    if (!value.includes(item[key]?.toString())) {
                        return false;
                    }
                } else if (item[key] !== value) {
                    return false;
                }
            }
            return true;
        });
    },
};

// ============================================
// SEARCH UTILITIES
// ============================================

const SearchHelper = {
    /**
     * Search items by keyword
     */
    search: function(items, keyword, searchFields = ['name', 'description']) {
        if (!keyword || keyword.trim() === '') {
            return items;
        }

        const lowercaseKeyword = keyword.toLowerCase();

        return items.filter(item => {
            return searchFields.some(field => {
                const fieldValue = item[field]?.toString().toLowerCase();
                return fieldValue && fieldValue.includes(lowercaseKeyword);
            });
        });
    },

    /**
     * Highlight search keyword
     */
    highlightKeyword: function(text, keyword) {
        if (!keyword) return text;

        const regex = new RegExp(`(${keyword})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
    },
};

// ============================================
// SORT UTILITIES
// ============================================

const SortHelper = {
    /**
     * Sort items
     */
    sort: function(items, sortBy, order = 'asc') {
        const sorted = [...items];

        sorted.sort((a, b) => {
            const aValue = a[sortBy];
            const bValue = b[sortBy];

            if (typeof aValue === 'number' && typeof bValue === 'number') {
                return order === 'asc' ? aValue - bValue : bValue - aValue;
            }

            const comparison = aValue?.toString().localeCompare(bValue?.toString());
            return order === 'asc' ? comparison : -comparison;
        });

        return sorted;
    },

    /**
     * Sort by price
     */
    sortByPrice: function(items, order = 'asc') {
        return this.sort(items, 'price', order);
    },

    /**
     * Sort by name
     */
    sortByName: function(items, order = 'asc') {
        return this.sort(items, 'name', order);
    },

    /**
     * Sort by rating
     */
    sortByRating: function(items, order = 'desc') {
        return this.sort(items, 'rating', order);
    },
};

// ============================================
// PAGINATION UTILITIES
// ============================================

const PaginationHelper = {
    /**
     * Paginate items
     */
    paginate: function(items, page = 1, perPage = 10) {
        const totalPages = Math.ceil(items.length / perPage);
        const start = (page - 1) * perPage;
        const end = start + perPage;

        return {
            items: items.slice(start, end),
            page,
            perPage,
            total: items.length,
            totalPages,
            hasNextPage: page < totalPages,
            hasPreviousPage: page > 1,
        };
    },

    /**
     * Generate pagination links
     */
    generateLinks: function(currentPage, totalPages, maxLinks = 5) {
        const links = [];
        let startPage = Math.max(1, currentPage - Math.floor(maxLinks / 2));
        let endPage = Math.min(totalPages, startPage + maxLinks - 1);

        if (endPage - startPage < maxLinks - 1) {
            startPage = Math.max(1, endPage - maxLinks + 1);
        }

        if (startPage > 1) {
            links.push({ page: 1, label: '1' });
            if (startPage > 2) {
                links.push({ page: '...', label: '...' });
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            links.push({
                page: i,
                label: i.toString(),
                active: i === currentPage,
            });
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                links.push({ page: '...', label: '...' });
            }
            links.push({ page: totalPages, label: totalPages.toString() });
        }

        return links;
    },
};

// ============================================
// EXPORT
// ============================================

if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        CartHelper,
        ProductHelper,
        FilterHelper,
        SearchHelper,
        SortHelper,
        PaginationHelper,
    };
}

if (typeof window !== 'undefined') {
    window.CartHelper = CartHelper;
    window.ProductHelper = ProductHelper;
    window.FilterHelper = FilterHelper;
    window.SearchHelper = SearchHelper;
    window.SortHelper = SortHelper;
    window.PaginationHelper = PaginationHelper;
}
