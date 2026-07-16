// File mác định của Laravel (Axios, CSRF, cấu hình...)
import './bootstrap';

// Import thư viện Bootstrap từ node_modules
import 'bootstrap';

// Import file JavaScript tự viết
/* . : thư mục hiện tại (resources/js) */
import './custom';
import './helpers';

window.addEventListener('DOMContentLoaded', () => {
    if (window.CartHelper && typeof window.CartHelper.updateUI === 'function') {
        window.CartHelper.updateUI();
    }
});
