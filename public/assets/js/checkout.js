const CART_KEY = "cantina_cart";

function getCart() {
  return JSON.parse(localStorage.getItem(CART_KEY) || "[]");
}

function fmt(value) {
  return "R$ " + value.toFixed(2).replace(".", ",");
}

function renderReceipt() {
  const cart = getCart();
  const itemsEl = document.getElementById("receipt-items");
  const totalEl = document.getElementById("receipt-total");
  const countEl = document.getElementById("item-count");
  const emptyMsg = document.getElementById("empty-cart-msg");
  const receiptBody = document.getElementById("receipt-body");
  const confirmBtn = document.getElementById("btn-confirm");

  const total = cart.reduce((s, i) => s + i.price * i.qty, 0);
  const count = cart.reduce((s, i) => s + i.qty, 0);

  totalEl.textContent = fmt(total);
  countEl.textContent = count + (count === 1 ? " item" : " itens");

  if (cart.length === 0) {
    receiptBody.classList.add("d-none");
    confirmBtn.disabled = true;
    confirmBtn.style.opacity = ".5";
    emptyMsg.classList.remove("d-none");
    return;
  }

  emptyMsg.classList.add("d-none");
  receiptBody.classList.remove("d-none");
  confirmBtn.disabled = false;
  confirmBtn.style.opacity = "1";

  itemsEl.innerHTML = cart
    .map(
      (item) => `
    <div class="d-flex justify-content-between align-items-start py-1 receipt-line">
      <div class="d-flex gap-2 align-items-baseline overflow-hidden me-2">
        <span class="receipt-qty">${item.qty}x</span>
        <span class="receipt-name text-truncate">${item.name}</span>
      </div>
      <span class="receipt-price flex-shrink-0">${fmt(item.price * item.qty)}</span>
    </div>`
    )
    .join("");
}

async function confirmOrder() {
  const nameInput = document.getElementById("customer-name");
  const name = nameInput.value.trim();

  if (!name) {
    nameInput.classList.add("is-invalid");
    nameInput.focus();
    return;
  }
  nameInput.classList.remove("is-invalid");

  const btn = document.getElementById("btn-confirm");
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando…';

  const cart = getCart();

  try {
    const res = await fetch(CANTINA_URL + "api/checkout", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-API-Key": API_KEY,
      },
      body: JSON.stringify({
        status: "aguardando",
        cliente: name,
        totem: (function () { try { const t = JSON.parse(localStorage.getItem("cantina_totem")); return t ? t.id : null; } catch (e) { return null; } })(),
        produtos: cart.map((item) => ({
          id_produto: item.id,
          quantidade: item.qty,
          preco_unitario: item.price,
        })),
      }),
    });

    if (res.status === 403) {
      clearTotemAndRedirect();
      return;
    }

    if (!res.ok) {
      throw new Error("HTTP " + res.status);
    }

    const data = await res.json();
    showConfirmed(name, data.id_pedido);
  } catch (err) {
    console.error("Erro ao enviar pedido:", err);
    btn.disabled = false;
    btn.innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i>Confirmar pedido';
    alert("Não foi possível enviar o pedido. Tente novamente.");
  }
}

function startUrl() {
  return BASE_URL;
}

function showConfirmed(name, orderNumber) {
  const nameInput = document.getElementById("customer-name");
  nameInput.disabled = true;

  document.getElementById("btn-confirm").classList.add("d-none");
  document.getElementById("name-section").classList.add("d-none");

  document.getElementById("order-confirmed").classList.remove("d-none");
  document.getElementById("order-number").textContent =
    "#" + String(orderNumber).padStart(3, "0");
  document.getElementById("order-name").textContent = name;

  localStorage.removeItem(CART_KEY);

  const finishBtn = document.getElementById("btn-finish");
  finishBtn.href = startUrl();
  finishBtn.classList.remove("d-none");

  let secondsLeft = 10;
  const countdownEl = document.getElementById("countdown");
  const timer = setInterval(() => {
    secondsLeft--;
    countdownEl.textContent = secondsLeft;
    if (secondsLeft <= 0) {
      clearInterval(timer);
      window.location.href = startUrl();
    }
  }, 1000);

  finishBtn.addEventListener("click", () => clearInterval(timer));
}

document.getElementById("btn-confirm").addEventListener("click", confirmOrder);

document.getElementById("customer-name").addEventListener("input", function () {
  if (this.value.trim()) this.classList.remove("is-invalid");
});

renderReceipt();
