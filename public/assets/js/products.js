'use strict';

const ICONS = {
    lanches:    'fa-burger',
    bebidas:    'fa-bottle-water',
    sobremesas: 'fa-ice-cream',
    outros:     'fa-utensils',
};

function fmt(price) {
    return 'R$ ' + price.toFixed(2).replace('.', ',');
}

function updateCartTotal() {
    const cart = JSON.parse(localStorage.getItem('cantina_cart') || '[]');
    const total = cart.reduce((sum, i) => sum + i.price * i.qty, 0);
    document.getElementById('cart-total').textContent =
        'R$ ' + total.toFixed(2).replace('.', ',');
}

function renderProducts(produtos) {
    const grid = document.getElementById('product-grid');

    if (produtos.length === 0) {
        grid.innerHTML = `
            <div class="col-12 text-center py-5 text-muted">
                <i class="fa-solid fa-triangle-exclamation fa-3x mb-3"></i>
                <p>Nenhum produto disponível no momento.</p>
            </div>`;
        return;
    }

    grid.innerHTML = produtos.map(p => `
        <div class="col product-item" data-category="${p.category}">
            <div class="card product-card h-100 shadow-sm overflow-hidden">
                <div class="product-img-wrap">
                    ${p.img
                        ? `<img src="${p.img}" alt="${p.name}">`
                        : `<span class="img-placeholder"><i class="fa-solid ${p.icon}"></i></span>`}
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="d-flex flex-column flex-md-row align-items-md-baseline justify-content-md-between gap-1 mb-1">
                        <h6 class="card-title fw-bold mb-0">${p.name}</h6>
                        <span class="price-tag text-nowrap">${fmt(p.price)}</span>
                    </div>
                    <button class="btn btn-success btn-add w-100 btn-sm mt-auto"
                        data-id="${p.id}"
                        data-name="${p.name}"
                        data-price="${p.price}"
                        data-icon="${p.icon}"
                        data-img="${p.img}">
                        <i class="fa-solid fa-plus me-1"></i>Adicionar
                    </button>
                </div>
            </div>
        </div>`).join('');

    grid.querySelectorAll('.btn-add').forEach(btn => {
        btn.addEventListener('click', () => {
            const cart = JSON.parse(localStorage.getItem('cantina_cart') || '[]');
            const id = parseInt(btn.dataset.id);
            const existing = cart.find(i => i.id === id);
            if (existing) {
                existing.qty++;
            } else {
                cart.push({
                    id,
                    name:  btn.dataset.name,
                    price: parseFloat(btn.dataset.price),
                    icon:  btn.dataset.icon || 'fa-utensils',
                    img:   btn.dataset.img || '',
                    qty:   1,
                });
            }
            localStorage.setItem('cantina_cart', JSON.stringify(cart));
            updateCartTotal();

            btn.innerHTML = '<i class="fa-solid fa-check me-1"></i>Adicionado!';
            btn.classList.replace('btn-success', 'btn-outline-success');
            btn.disabled = true;
            setTimeout(() => {
                btn.innerHTML = '<i class="fa-solid fa-plus me-1"></i>Adicionar';
                btn.classList.replace('btn-outline-success', 'btn-success');
                btn.disabled = false;
            }, 900);
        });
    });
}

async function loadProducts() {
    const grid = document.getElementById('product-grid');
    if (!(await verifyTotem())) return;
    try {
        const res = await fetch(CANTINA_URL + 'api/produtos', {
            headers: { 'X-API-Key': API_KEY },
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const raw = await res.json();

        const base = CANTINA_URL.replace(/\/$/, '');
        const produtos = raw
            .map(p => ({
                id:       p.id,
                name:     p.nome,
                category: p.categoria || 'outros',
                price:    parseFloat(p.preco),
                img:      p.foto ? base + '/uploads/produtos/' + p.foto : '',
                icon:     ICONS[p.categoria] || 'fa-utensils',
            }));

        renderProducts(produtos);
    } catch (err) {
        console.error('Erro ao carregar produtos:', err);
        grid.innerHTML = `
            <div class="col-12 text-center py-5 text-muted">
                <i class="fa-solid fa-triangle-exclamation fa-3x mb-3"></i>
                <p>Erro ao carregar produtos. Tente novamente.</p>
            </div>`;
    }
}

document.querySelectorAll('.category-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const cat = btn.dataset.category;
        document.querySelectorAll('.product-item').forEach(item => {
            item.style.display = cat === 'todos' || item.dataset.category === cat ? '' : 'none';
        });
    });
});

updateCartTotal();
loadProducts();
