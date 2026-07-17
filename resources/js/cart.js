const cartForms = () => document.querySelectorAll('.form-add-cart');

const handleAddToCartForm = (form) => {
    const url = form.action;
    const formData = new FormData(form);

    fetch(url, {
        method: 'POST',
        credentials: 'same-origin',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
    .then(res => {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    })
    .then(data => {
        const cartCount = document.getElementById('cart-count');
        if (cartCount && data.cartCount !== undefined) {
            cartCount.innerText = data.cartCount;
        }
        alert(data.message);
    })
    .catch(err => {
        console.error('Lỗi:', err);
        alert('Có lỗi xảy ra khi thêm vào giỏ hàng.');
    });
};

document.addEventListener('submit', function (e) {
    const form = e.target.closest('.form-add-cart');
    if (!form) return;

    e.preventDefault();
    handleAddToCartForm(form);
});

document.addEventListener('DOMContentLoaded', function () {
    cartForms().forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            handleAddToCartForm(form);
        });
    });
});

document.addEventListener('submit', function (e) {
    const form = e.target.closest('.remove-cart-form');
    if (!form) return;

    e.preventDefault();
    if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
        return;
    }

    removeCart(form);
});

function addToCart(form) {
    handleAddToCartForm(form);
}

function removeCart(form) {
    const url = form.action;
    const token = document.querySelector('meta[name="csrf-token"]')?.content || form.querySelector('input[name="_token"]')?.value;

    if (!url) {
        alert('Không xác định được đường dẫn xóa. Vui lòng thử lại.');
        return;
    }

    if (!token) {
        alert('Không tìm thấy CSRF token. Vui lòng tải lại trang.');
        return;
    }

    fetch(url, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token,
        },
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('HTTP ' + res.status);
        }
        return res.json();
    })
    .then(data => {
        if (!data.status) {
            alert(data.message);
            return;
        }

        const row = btn.closest('tr');
        if (row) {
            row.remove();
        }

        const cartCount = document.getElementById('cart-count');
        if (cartCount) {
            cartCount.innerText = data.cartCount;
        }

        const totalQuantity = document.getElementById('totalQuantity');
        if (totalQuantity) {
            totalQuantity.innerText = data.cartCount;
        }

        const total = document.getElementById('total');
        if (total) {
            total.innerText = Number(data.total).toLocaleString('vi-VN') + ' đ';
        }

        if (data.isEmpty) {
            location.reload();
        }
    })
    .catch(err => {
        console.error(err);
        alert('Có lỗi xảy ra!');
    });
}
