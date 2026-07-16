/**
 * ============================================
 * CUSTOM JAVASCRIPT
 * Project: E-Commerce MyWeb
 * ============================================
 */

// ============================================
// 1. UTILITY FUNCTIONS
// ============================================

/**
 * Show toast notification
 */
const showToast = (message, type = 'success', duration = 3000) => {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    
    // Add styles
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    toastContainer.appendChild(toast);
    
    // Show animation
    setTimeout(() => toast.classList.add('show'), 10);
    
    // Auto remove
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, duration);
};

/**
 * Create toast container if it doesn't exist
 */
const createToastContainer = () => {
    const container = document.createElement('div');
    container.id = 'toast-container';
    document.body.appendChild(container);
    return container;
};

/**
 * Show loading spinner
 */
const showLoading = (element) => {
    if (element) {
        element.innerHTML = '<span class="spinner"></span> Loading...';
        element.disabled = true;
    }
};

/**
 * Hide loading spinner
 */
const hideLoading = (element, text = '') => {
    if (element) {
        element.innerHTML = text;
        element.disabled = false;
    }
};

/**
 * Format price
 */
const formatPrice = (price) => {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
    }).format(price);
};

/**
 * Debounce function
 */
const debounce = (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

/**
 * Throttle function
 */
const throttle = (func, limit) => {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
};

if (typeof window !== 'undefined') {
    window.showToast = showToast;
    window.formatPrice = formatPrice;
}

// ============================================
// 2. DOM MANIPULATION
// ============================================

/**
 * Toggle element visibility
 */
const toggleElement = (selector) => {
    const element = document.querySelector(selector);
    if (element) {
        element.classList.toggle('hidden');
    }
};

/**
 * Add event listener to multiple elements
 */
const addEventListeners = (selector, event, callback) => {
    const elements = document.querySelectorAll(selector);
    elements.forEach(el => {
        el.addEventListener(event, callback);
    });
};

/**
 * Remove loading class from all elements
 */
const removeLoadingClass = () => {
    document.querySelectorAll('.loading').forEach(el => {
        el.classList.remove('loading');
    });
};

// ============================================
// 3. FORM HANDLING
// ============================================

/**
 * Clear form inputs
 */
const clearForm = (formId) => {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
        form.querySelectorAll('.form-error').forEach(el => el.remove());
    }
};

/**
 * Display form errors
 */
const displayFormErrors = (errors, formId) => {
    const form = document.getElementById(formId);
    if (!form) return;

    // Clear previous errors
    form.querySelectorAll('.form-error').forEach(el => el.remove());

    // Display new errors
    Object.keys(errors).forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            const errorElement = document.createElement('span');
            errorElement.className = 'form-error';
            errorElement.textContent = errors[field][0];
            input.parentNode.appendChild(errorElement);
            input.classList.add('is-invalid');
        }
    });
};

/**
 * Clear form errors
 */
const clearFormErrors = (formId) => {
    const form = document.getElementById(formId);
    if (form) {
        form.querySelectorAll('.form-error').forEach(el => el.remove());
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }
};

// ============================================
// 4. API/FETCH HELPERS
// ============================================

/**
 * Make AJAX request
 */
const makeRequest = async (url, options = {}) => {
        const csrfToken = window.csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const defaultOptions = {
        credentials: 'same-origin',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
        },
    };

    const config = { ...defaultOptions, ...options };

    try {
        const response = await fetch(url, config);
        
        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error('Request error:', error);
        throw error;
    }
};

/**
 * POST request
 */
const post = (url, data = {}) => {
    return makeRequest(url, {
        method: 'POST',
        body: JSON.stringify(data),
    });
};

/**
 * GET request
 */
const get = (url) => {
    return makeRequest(url, {
        method: 'GET',
    });
};

/**
 * PUT request
 */
const put = (url, data = {}) => {
    return makeRequest(url, {
        method: 'PUT',
        body: JSON.stringify(data),
    });
};

/**
 * DELETE request
 */
const deleteRequest = (url) => {
    return makeRequest(url, {
        method: 'DELETE',
    });
};

if (typeof window !== 'undefined') {
    window.makeRequest = makeRequest;
    window.post = post;
    window.get = get;
    window.put = put;
    window.deleteRequest = deleteRequest;
}

// ============================================
// 5. VALIDATION
// ============================================

/**
 * Validate email
 */
const isValidEmail = (email) => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
};

/**
 * Validate phone number (Vietnam)
 */
const isValidPhoneVN = (phone) => {
    const phoneRegex = /(84|0[3|5|7|8|9])+([0-9]{8})\b/;
    return phoneRegex.test(phone);
};

/**
 * Validate password strength
 */
const isStrongPassword = (password) => {
    return password.length >= 8 && 
           /[A-Z]/.test(password) && 
           /[0-9]/.test(password) && 
           /[!@#$%^&*]/.test(password);
};

// ============================================
// 6. DOCUMENT READY
// ============================================

/**
 * Initialize on document ready
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Custom JS loaded successfully');

    // Add your initialization code here
    initializeEventListeners();
    setupAjaxDefaults();
});

/**
 * Initialize event listeners
 */
function initializeEventListeners() {
    // Example: Add click handlers
    // addEventListeners('.btn', 'click', handleButtonClick);
}

/**
 * Setup AJAX defaults
 */
function setupAjaxDefaults() {
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        window.csrfToken = csrfToken.getAttribute('content');
    }
}

// ============================================
// 7. EXPORT FOR MODULE USAGE
// ============================================

// For use in other files if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        showToast,
        showLoading,
        hideLoading,
        formatPrice,
        debounce,
        throttle,
        toggleElement,
        addEventListeners,
        clearForm,
        displayFormErrors,
        clearFormErrors,
        makeRequest,
        post,
        get,
        put,
        deleteRequest,
        isValidEmail,
        isValidPhoneVN,
        isStrongPassword,
    };
}
