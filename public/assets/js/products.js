document.querySelectorAll(".category-btn").forEach((btn) => {
  btn.addEventListener("click", () => {
    document.querySelectorAll(".category-btn").forEach((b) => b.classList.remove("active"));
    btn.classList.add("active");
    const cat = btn.dataset.category;
    document.querySelectorAll(".product-item").forEach((item) => {
      item.style.display = cat === "todos" || item.dataset.category === cat ? "" : "none";
    });
  });
});

function updateCartTotal() {
  const cart = JSON.parse(localStorage.getItem("cantina_cart") || "[]");
  const total = cart.reduce((sum, i) => sum + i.price * i.qty, 0);
  document.getElementById("cart-total").textContent =
    "R$ " + total.toFixed(2).replace(".", ",");
}

document.querySelectorAll(".btn-add").forEach((btn) => {
  btn.addEventListener("click", () => {
    const cart = JSON.parse(localStorage.getItem("cantina_cart") || "[]");
    const id = parseInt(btn.dataset.id);
    const existing = cart.find((i) => i.id === id);
    if (existing) {
      existing.qty++;
    } else {
      cart.push({
        id,
        name: btn.dataset.name,
        price: parseFloat(btn.dataset.price),
        description: btn.dataset.description || "",
        icon: btn.dataset.icon || "fa-utensils",
        img: btn.dataset.img || "",
        qty: 1,
      });
    }
    localStorage.setItem("cantina_cart", JSON.stringify(cart));
    updateCartTotal();

    btn.innerHTML = '<i class="fa-solid fa-check me-1"></i>Adicionado!';
    btn.classList.replace("btn-success", "btn-outline-success");
    btn.disabled = true;
    setTimeout(() => {
      btn.innerHTML = '<i class="fa-solid fa-plus me-1"></i>Adicionar';
      btn.classList.replace("btn-outline-success", "btn-success");
      btn.disabled = false;
    }, 900);
  });
});

updateCartTotal();
