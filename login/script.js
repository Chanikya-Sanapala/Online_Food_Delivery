// script.js
document.addEventListener("DOMContentLoaded", () => {
  // --- DOM references ---
  const addButtons = document.querySelectorAll(".add-to-cart");
  const orderWrapper = document.querySelector(".order-wrapper");
  const subtotalText = document.getElementById("subtotalText");
  const discountText = document.getElementById("discountText");
  const couponText = document.getElementById("couponText");
  const deliveryText = document.getElementById("deliveryText");
  const totalText = document.getElementById("totalText");
  const youSave = document.getElementById("youSave");
  const couponInput = document.getElementById("couponCode");
  const applyCouponBtn = document.getElementById("applyCouponBtn");
  const userAddressEl = document.getElementById("userAddress");
  const checkoutBtn = document.getElementById("checkoutBtn");
  const modal = document.getElementById("orderConfirmation");
  const closeConfirm = document.getElementById("closeConfirm");
  const cartIcon = document.querySelector(".label-cart");
  const cartPanel = document.querySelector(".dashboard-order");

  // --- Constants ---
  const TAX_RATE = 0.10;
  const DELIVERY_FEE = 75;

  // --- State ---
  const cart = {};
  let couponApplied = null;
  let usedCoupons = JSON.parse(localStorage.getItem("usedCoupons") || "[]");

  // Coupons
  const coupons = {
    FIRST50: { type: "percent", value: 50 },
    FREEDEL: { type: "delivery", value: 0 },
    SAVE10: { type: "percent", value: 10 },
    WELCOME50: { type: "flat", value: 50 }
  };

  // --- Helpers ---
  const rs = (v) => "Rs." + Number(v).toFixed(2);
  const safeNum = (v) => Number.isFinite(Number(v)) ? Number(v) : 0;

  // --- Load saved address ---
  const savedAddress = localStorage.getItem("deliveryAddress");
  if (savedAddress && userAddressEl) userAddressEl.textContent = savedAddress;

  // --- Add item ---
  function addItem(name, price, image) {
    price = safeNum(price);
    if (price <= 0) {
      alert(`Item "${name}" has invalid price.`);
      return;
    }
    if (!cart[name]) cart[name] = { price, qty: 0, image: image || "" };
    cart[name].qty += 1;
    render();
    cartPanel.classList.add("active"); // auto-open cart
  }

  // --- Update qty ---
  function updateQty(name, delta) {
    if (!cart[name]) return;
    cart[name].qty += delta;
    if (cart[name].qty <= 0) delete cart[name];
    render();
  }

  // --- Remove item ---
  function removeItem(name) {
    if (!cart[name]) return;
    delete cart[name];
    render();
  }

  // --- Totals ---
  function computeTotals() {
    let subtotal = 0;
    for (const k of Object.keys(cart)) subtotal += cart[k].price * cart[k].qty;
    const tax = subtotal * TAX_RATE;
    let delivery = subtotal > 0 ? DELIVERY_FEE : 0;

    // coupon discount
    let couponDiscount = 0;
    if (couponApplied) {
      if (couponApplied.type === "percent") {
        couponDiscount = (subtotal + tax + delivery) * (couponApplied.value / 100);
      } else if (couponApplied.type === "delivery") {
        couponDiscount = delivery;
        delivery = 0;
      } else if (couponApplied.type === "flat") {
        couponDiscount = couponApplied.value;
      }
      couponDiscount = Math.min(couponDiscount, subtotal + tax + delivery);
    }

    const total = Math.max(0, subtotal + tax + delivery - couponDiscount);
    return { subtotal, tax, delivery, couponDiscount, total, savings: couponDiscount };
  }

  // --- Render UI ---
  function render() {
    orderWrapper.innerHTML = "";
    Object.keys(cart).forEach((name) => {
      const item = cart[name];
      const row = document.createElement("div");
      row.className = "order-card";
      row.innerHTML = `
        <img class="order-image" src="${item.image}" alt="${name}">
        <div class="order-detail">
          <p>${name}</p>
          <div style="display:flex;align-items:center;gap:8px;margin-top:6px;">
            <button class="qty-btn qty-decrease" data-name="${escapeHtml(name)}">-</button>
            <input type="text" value="${item.qty}" readonly style="width:40px;text-align:center;border:1px solid #ddd;padding:4px;border-radius:4px;">
            <button class="qty-btn qty-increase" data-name="${escapeHtml(name)}">+</button>
            <button class="remove-item" data-name="${escapeHtml(name)}" title="Remove" style="margin-left:8px;background:transparent;border:none;cursor:pointer;color:#c0392b;">✖</button>
          </div>
        </div>
        <div style="min-width:70px;text-align:right;font-weight:600">${rs(item.price * item.qty)}</div>
      `;
      orderWrapper.appendChild(row);
    });

    const { subtotal, tax, delivery, couponDiscount, total, savings } = computeTotals();
    subtotalText.textContent = rs(subtotal);
    discountText.textContent = rs(0);
    couponText.textContent = "-" + rs(couponDiscount);
    deliveryText.textContent = rs(delivery);
    totalText.innerHTML = `<strong>${rs(total)}</strong>`;
    youSave.textContent = savings > 0 ? `You will save ${rs(savings)} on this order` : "";

    if (Object.keys(cart).length === 0) {
      orderWrapper.innerHTML = `<div style="padding:12px;color:#666;">Your cart is empty</div>`;
    }
  }

  function escapeHtml(str) {
    return String(str).replace(/"/g, "&quot;");
  }

  // --- Add button events ---
  addButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const gallery = btn.closest(".gallery");
      const nameEl = gallery ? gallery.querySelector(".description") : null;
      const name = nameEl ? nameEl.textContent.trim() : "Item";
      const price = parseFloat(btn.getAttribute("data-price")) || 0;
      const imgEl = gallery ? gallery.querySelector("img") : null;
      const image = imgEl ? imgEl.src : "";
      addItem(name, price, image);
    });
  });

  // --- Quantity +/- & remove ---
  orderWrapper.addEventListener("click", (ev) => {
    const t = ev.target;
    if (t.classList.contains("qty-increase")) {
      updateQty(t.getAttribute("data-name"), +1);
    } else if (t.classList.contains("qty-decrease")) {
      updateQty(t.getAttribute("data-name"), -1);
    } else if (t.classList.contains("remove-item")) {
      removeItem(t.getAttribute("data-name"));
    }
  });

  // --- Apply coupon ---
  applyCouponBtn && applyCouponBtn.addEventListener("click", () => {
    const code = (couponInput.value || "").trim().toUpperCase();
    if (!code) return alert("Please enter a coupon code.");
    if (!coupons[code]) return alert("Invalid coupon");
    if (usedCoupons.includes(code)) return alert("You already used this coupon.");

    couponApplied = coupons[code];
    usedCoupons.push(code);
    localStorage.setItem("usedCoupons", JSON.stringify(usedCoupons));
    alert(`Coupon applied: ${code}`);
    render();
  });

  // --- Save address ---
  if (userAddressEl) {
    userAddressEl.addEventListener("blur", () => {
      const val = userAddressEl.textContent.trim();
      localStorage.setItem("deliveryAddress", val);
    });
  }

  // --- Checkout ---
  checkoutBtn && checkoutBtn.addEventListener("click", () => {
    const subtotal = Object.keys(cart).reduce((s, k) => s + cart[k].price * cart[k].qty, 0);
    if (subtotal <= 0) return alert("Your cart is empty.");
    const addr = userAddressEl ? userAddressEl.textContent.trim() : "";
    if (!addr) return alert("Please enter delivery address.");

    const totals = computeTotals();
    const msgEl = document.getElementById("confirmMsg");
    if (msgEl) msgEl.textContent = `Order placed. Total ${rs(totals.total)}. Delivery to: ${addr}`;
    modal.style.display = "flex";
    modal.setAttribute("aria-hidden", "false");

    for (const k of Object.keys(cart)) delete cart[k];
    couponApplied = null;
    render();
  });

  // --- Close modal ---
  closeConfirm && closeConfirm.addEventListener("click", () => {
    modal.style.display = "none";
    modal.setAttribute("aria-hidden", "true");
  });

  // --- Cart toggle (manual open/close) ---
  cartIcon.addEventListener("click", () => {
    cartPanel.classList.toggle("active");
  });
  // Detect user location and auto-fill
function detectLocation() {
  if (!navigator.geolocation) {
    console.warn("Geolocation not supported by your browser.");
    return;
  }

  navigator.geolocation.getCurrentPosition(success, error);

  function success(position) {
    const lat = position.coords.latitude;
    const lon = position.coords.longitude;

    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
      .then(response => response.json())
      .then(data => {
        const address = data.display_name || `Lat: ${lat}, Lon: ${lon}`;
        const userAddressEl = document.getElementById("userAddress");

        if (userAddressEl) {
          userAddressEl.textContent = address;
        }

        // Save in local storage
        localStorage.setItem("deliveryAddress", address);

        // Save to DB
        saveAddressToDB(address);
      })
      .catch(err => console.error("Error fetching address:", err));
  }

  function error() {
    console.warn("Unable to retrieve location.");
  }
}

// Save address into DB
function saveAddressToDB(address) {
  fetch("save_address.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "address=" + encodeURIComponent(address)
  })
    .then(res => res.text())
    .then(msg => console.log("Server:", msg))
    .catch(err => console.error("DB Save Error:", err));
}

// Load saved address if available
document.addEventListener("DOMContentLoaded", () => {
  const savedAddress = localStorage.getItem("deliveryAddress");
  const userAddressEl = document.getElementById("userAddress");

  if (savedAddress && userAddressEl) {
    userAddressEl.textContent = savedAddress;
  } else {
    detectLocation(); // auto-detect if nothing saved
  }

  // Save address when user edits manually
  if (userAddressEl) {
    userAddressEl.addEventListener("blur", () => {
      const newAddress = userAddressEl.textContent.trim();
      if (newAddress) {
        localStorage.setItem("deliveryAddress", newAddress);
        saveAddressToDB(newAddress);
      }
    });
  }
});
// call this early (after DOM ready)
function loadAddressFromServer() {
  fetch('get_address.php', { credentials: 'same-origin' })
    .then(r => r.json())
    .then(data => {
      if (data.ok && data.address) {
        const el = document.getElementById('userAddress');
        if (el) el.textContent = data.address;
        localStorage.setItem('deliveryAddress', data.address);
      } else {
        // no address in DB — maybe fallback to localStorage or detect location
        const local = localStorage.getItem('deliveryAddress');
        if (local) document.getElementById('userAddress').textContent = local;
        else detectLocationAndSave(); // optionally try geolocation
      }
    })
    .catch(err => console.error('get_address error', err));
}

function saveAddressToServer(address, lat = '', lon = '') {
  // send as form data
  const body = new URLSearchParams();
  body.append('address', address);
  if (lat) body.append('lat', lat);
  if (lon) body.append('lon', lon);

  fetch('save_address.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: body.toString(),
    credentials: 'same-origin'
  })
    .then(r => r.json())
    .then(data => {
      if (!data.ok) console.warn('save address failed:', data.msg);
    })
    .catch(err => console.error('save_address error', err));
}


  // --- Initial render ---
  render();
});
