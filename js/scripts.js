document.addEventListener('DOMContentLoaded', async () => {

    await loadUser();

    await fetchProducts();

    if (document.getElementById('cart-container')) {
        await loadCart();
    }
});

let currentUserId = null;

function escapeHtml(value) {
    const chars = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };

    return String(value ?? '').replace(/[&<>"']/g, ch => chars[ch]);
}

async function loadUser() {

    try {

        const r = await fetch('php/me.php');
        const u = await r.json();

        if (u.logged_in) {
            currentUserId = u.user_id;
        }

    } catch (e) {
        console.error('Ошибка пользователя:', e);
    }
}

async function fetchProducts() {

    const list = document.getElementById('product-list');
    if (!list) return;

    try {

        const [productsRes, cartRes] = await Promise.all([
            fetch('php/get_products.php'),
            fetch('php/get_cart.php')
        ]);

        const products = await productsRes.json();
        const cart = await cartRes.json();

        list.innerHTML = '';

        products.forEach(p => {

            const productId = Number(p.product_id);
            const productName = escapeHtml(p.product_name);
            const imageUrl = escapeHtml(p.image_url);
            const price = Number(p.price);

            const item = cart.find(
                i => Number(i.product_id) === productId
            );

            const controls = item
                ? `
                    <div class="qty-controls">
                        <button onclick="decreaseItem(${productId})">
                            -
                        </button>

                        <span>${Number(item.quantity)}</span>

                        <button onclick="increaseItem(${productId})">
                            +
                        </button>
                    </div>
                `
                : `
                    <button onclick="addToCart(${productId})">
                        Купить
                    </button>
                `;

            list.innerHTML += `
                <div class="product-card">

                    <img
                        src="images/${imageUrl}"
                        alt="${productName}"
                    >

                    <h3>${productName}</h3>

                    <p>${price}₽</p>

                    ${controls}

                </div>
            `;
        });

    } catch (e) {
        console.error('Ошибка товаров:', e);
    }
}

async function addToCart(productId) {

    if (!currentUserId) {

        alert('Войдите');
        location.href = 'login.php';
        return;
    }

    try {

        const r = await fetch(
            'php/add_to_cart.php',
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            }
        );

        const data = await r.json();

        if (data.status === 'success') {
            await refreshUI();
        }

    } catch (e) {
        console.error('Ошибка корзины:', e);
    }
}

async function increaseItem(productId) {

    try {

        const r = await fetch(
            'php/update_cart.php',
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    action: 'increase'
                })
            }
        );

        const data = await r.json();

        if (data.status === 'success') {
            await refreshUI();
        }

    } catch (e) {
        console.error('Ошибка +:', e);
    }
}

async function decreaseItem(productId) {

    try {

        const r = await fetch(
            'php/update_cart.php',
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    action: 'decrease'
                })
            }
        );

        const data = await r.json();

        if (data.status === 'success') {
            await refreshUI();
        }

    } catch (e) {
        console.error('Ошибка -:', e);
    }
}

async function loadCart() {

    const box = document.getElementById('cart-container');
    if (!box) return;

    try {

        const r = await fetch('php/get_cart.php');
        const cart = await r.json();

        box.innerHTML = '';

        let total = 0;

        if (cart.length === 0) {

            box.innerHTML = `
                <div class="cart-item">
                    Корзина пустая
                </div>
            `;

            const t =
                document.getElementById('cart-total');

            if (t) {
                t.innerText = 'Итого: 0₽';
            }

            return;
        }

        cart.forEach(i => {

            const productId = Number(i.product_id);
            const productName = escapeHtml(i.product_name);
            const imageUrl = escapeHtml(i.image_url);
            const price = Number(i.price);
            const quantity = Number(i.quantity);

            const sum =
                price *
                quantity;

            total += sum;

            box.innerHTML += `
                <div class="cart-item">

                    <div class="cart-left">

                        <img
                            src="images/${imageUrl}"
                            alt="${productName}"
                        >

                        <div>

                            <div class="cart-name">
                                ${productName}
                            </div>

                            <div class="cart-price">
                                ${price}₽
                            </div>

                        </div>

                    </div>

                    <div class="cart-controls">

                        <button
                            onclick="decreaseItem(${productId})"
                        >
                            -
                        </button>

                        <span>
                            ${quantity}
                        </span>

                        <button
                            onclick="increaseItem(${productId})"
                        >
                            +
                        </button>

                        <strong>
                            ${sum}₽
                        </strong>

                    </div>

                </div>
            `;
        });

        const t =
            document.getElementById('cart-total');

        if (t) {
            t.innerText =
                `Итого: ${total}₽`;
        }

    } catch (e) {
        console.error(
            'Ошибка корзины:',
            e
        );
    }
}

async function makeOrder() {

    try {

        const r = await fetch(
            'php/order_product.php',
            {
                method: 'POST'
            }
        );

        const data = await r.json();

        if (data.status === 'success') {

            alert('Заказ #' + data.order_id + ' оформлен');

            await refreshUI();
        } else {

            alert('Корзина пуста');
        }

    } catch (e) {
        console.error(e);
    }
}

function logout() {

    fetch('php/logout.php')
        .then(() => {
            location.href = 'index.php';
        });
}


async function refreshUI() {
    await fetchProducts();
    await loadCart();
}
