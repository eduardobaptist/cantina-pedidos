const CART_KEY = "cantina_cart";

function getCart() {
  return JSON.parse(localStorage.getItem(CART_KEY) || "[]");
}

function saveCart(cart) {
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

function fmt(value) {
  return "R$ " + value.toFixed(2).replace(".", ",");
}

function renderCart() {
  const cart       = getCart();
  const container  = document.getElementById("cart-items");
  const totalEl    = document.getElementById("cart-total");
  const countEl    = document.getElementById("item-count");
  const confirmBtn = document.getElementById("btn-confirm");

  const total = cart.reduce((s, i) => s + i.price * i.qty, 0);
  const count = cart.reduce((s, i) => s + i.qty, 0);

  totalEl.textContent = fmt(total);
  countEl.textContent = count + (count === 1 ? " item" : " itens");

  if (confirmBtn) {
    confirmBtn.style.opacity       = cart.length === 0 ? ".5" : "1";
    confirmBtn.style.pointerEvents = cart.length === 0 ? "none" : "";
  }

  if (cart.length === 0) {
    container.innerHTML = `
      <div class="d-flex flex-column align-items-center justify-content-center py-5 text-center">
        <i class="fa-solid fa-cart-shopping fa-4x text-muted mb-3"></i>
        <p class="text-muted mb-4">Seu carrinho está vazio.</p>
        <a href="${BASE_URL}" class="btn btn-sm text-white fw-semibold" style="background-color:#fd7e14">
          <i class="fa-solid fa-arrow-left me-1"></i>Ver cardápio
        </a>
      </div>`;
    return;
  }

  container.innerHTML = cart.map((item) => {
    const subtotal = item.price * item.qty;
    const imgHtml  = item.img
      ? `<img src="${item.img}" alt="${item.name}">`
      : `<i class="fa-solid ${item.icon || "fa-utensils"} icon-placeholder"></i>`;

    return `
    <div class="card cart-item-card shadow-sm mb-2" data-id="${item.id}">
      <div class="card-body px-3 py-2 d-flex flex-column flex-md-row align-items-md-center gap-2 gap-md-3">

        <!-- Image + info -->
        <div class="d-flex align-items-center gap-3 flex-grow-1 overflow-hidden">
          <div class="cart-img-wrap">${imgHtml}</div>
          <div class="overflow-hidden">
            <div class="d-flex align-items-baseline gap-2 flex-wrap">
              <span class="fw-bold">${item.name}</span>
              <span class="text-muted small">${fmt(item.price)} / un.</span>
            </div>
            ${item.description ? `<div class="text-muted small">${item.description}</div>` : ""}
          </div>
        </div>

        <!-- Controls: qty + subtotal + remove -->
        <div class="d-flex align-items-center justify-content-between justify-content-md-end gap-2 flex-shrink-0">
          <div class="d-flex align-items-center gap-1">
            <button class="btn btn-sm btn-outline-secondary qty-btn btn-minus" data-id="${item.id}">−</button>
            <input type="number" class="qty-input" value="${item.qty}" min="1" max="99" data-id="${item.id}">
            <button class="btn btn-sm btn-outline-secondary qty-btn btn-plus" data-id="${item.id}">+</button>
          </div>
          <div class="item-subtotal">${fmt(subtotal)}</div>
          <button class="btn btn-sm btn-outline-danger btn-remove" data-id="${item.id}">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>

      </div>
    </div>`;
  }).join("");

  document.querySelectorAll(".btn-minus").forEach((b) =>
    b.addEventListener("click", () => changeQty(parseInt(b.dataset.id), -1))
  );
  document.querySelectorAll(".btn-plus").forEach((b) =>
    b.addEventListener("click", () => changeQty(parseInt(b.dataset.id), 1))
  );
  document.querySelectorAll(".btn-remove").forEach((b) =>
    b.addEventListener("click", () => removeItem(parseInt(b.dataset.id)))
  );
  document.querySelectorAll(".qty-input").forEach((input) => {
    input.addEventListener("change", () => {
      const id  = parseInt(input.dataset.id);
      const qty = parseInt(input.value);
      if (isNaN(qty) || qty < 1) {
        const current = getCart().find((i) => i.id === id);
        input.value = current ? current.qty : 1;
        return;
      }
      const cart = getCart();
      const item = cart.find((i) => i.id === id);
      if (item) { item.qty = qty; saveCart(cart); renderCart(); }
    });
  });
}

function changeQty(id, delta) {
  const cart = getCart();
  const item = cart.find((i) => i.id === id);
  if (!item) return;
  item.qty += delta;
  if (item.qty <= 0) { removeItem(id); return; }
  saveCart(cart);
  renderCart();
}

function removeItem(id) {
  saveCart(getCart().filter((i) => i.id !== id));
  renderCart();
}

renderCart();
