// script.js
document.addEventListener("DOMContentLoaded", () => {
  // --- DOM references ---
  const addButtons = document.querySelectorAll(".add-to-cart, .add-btn");
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
  const menuBtn = document.getElementById('menu-btn');
  const sidebar = document.querySelector('.sidebar');

  // --- Constants ---
  const TAX_RATE = 0.10;
  const DELIVERY_FEE = 75;

  // --- State ---
  // Initialize cart from localStorage
  let cart = {};
  try {
    const saved = localStorage.getItem("shoppingCart");
    if (saved) cart = JSON.parse(saved);
  } catch (e) { console.error("Could not load cart", e); }

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

  // Persist Cart
  function saveCart() {
    localStorage.setItem("shoppingCart", JSON.stringify(cart));
  }

  // --- Toast Notification ---
  window.showToast = function (message, type = 'success') {
    let container = document.getElementById('toast-container');
    if (!container) {
      container = document.createElement('div');
      container.id = 'toast-container';
      document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    // Icons
    const icon = type === 'success' ? '<i class="fas fa-check-circle" style="color:#4cd964; font-size:20px;"></i>' : '<i class="fas fa-exclamation-circle" style="color:#ff3b30; font-size:20px;"></i>';

    toast.innerHTML = `${icon} <span>${message}</span>`;
    container.appendChild(toast);

    // Auto remove (animation handles fade out but we remove from DOM)
    setTimeout(() => {
      if (toast.parentNode) toast.parentNode.removeChild(toast);
    }, 3500);
  }

  // --- Load saved address ---
  const savedAddress = localStorage.getItem("deliveryAddress");
  if (savedAddress && userAddressEl) userAddressEl.textContent = savedAddress;

  // --- Add item ---
  function addItem(name, price, image) {
    price = safeNum(price);
    if (price <= 0) {
      showToast(`Item "${name}" has invalid price.`, 'error');
      return;
    }
    if (!cart[name]) cart[name] = { price, qty: 0, image: image || "" };
    cart[name].qty += 1;
    saveCart(); // Save changes
    render();
    cartPanel.classList.add("active"); // auto-open cart
    showToast(`${name} added to cart!`);
  }

  // --- Update qty ---
  function updateQty(name, delta) {
    if (!cart[name]) return;
    cart[name].qty += delta;
    if (cart[name].qty <= 0) delete cart[name];
    saveCart(); // Save changes
    render();
  }

  // --- Remove item ---
  function removeItem(name) {
    if (!cart[name]) return;
    delete cart[name];
    saveCart(); // Save changes
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
    // Check if elements exist before working on them
    if (!orderWrapper) return;

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
    if (subtotalText) subtotalText.textContent = rs(subtotal);
    if (discountText) discountText.textContent = rs(0);
    if (couponText) couponText.textContent = "-" + rs(couponDiscount);
    if (deliveryText) deliveryText.textContent = rs(delivery);
    if (totalText) totalText.innerHTML = `<strong>${rs(total)}</strong>`;
    if (youSave) youSave.textContent = savings > 0 ? `You will save ${rs(savings)} on this order` : "";

    if (Object.keys(cart).length === 0) {
      orderWrapper.innerHTML = `<div style="padding:12px;color:#666;">Your cart is empty</div>`;
    }
  }

  function escapeHtml(str) {
    return String(str).replace(/"/g, "&quot;");
  }

  // --- Event Delegation for Add Buttons ---
  document.body.addEventListener("click", (e) => {
    if (e.target.matches(".add-to-cart, .add-btn")) {
      const btn = e.target;
      // Find parent card
      const card = btn.closest(".gallery-card") || btn.closest(".result-item") || btn.closest(".gallery");

      if (!card) return;

      // Get Name
      const nameEl = card.querySelector(".gallery-name") || card.querySelector(".description") || card.querySelector("h3");
      const name = nameEl ? nameEl.textContent.trim() : "Item";

      // Get Price
      let price = parseFloat(btn.getAttribute("data-price"));
      if (isNaN(price)) {
        const priceEl = card.querySelector(".gallery-footer span") || card.querySelector(".price");
        if (priceEl) {
          const text = priceEl.textContent.replace(/[^0-9.]/g, "");
          price = parseFloat(text);
        }
      }
      price = safeNum(price);

      // Get Image
      const imgEl = card.querySelector("img");
      const image = imgEl ? imgEl.src : "";

      addItem(name, price, image);
    }
  });

  // --- Quantity +/- & remove ---
  if (orderWrapper) {
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
  }

  // --- Apply coupon ---
  applyCouponBtn && applyCouponBtn.addEventListener("click", () => {
    const code = (couponInput.value || "").trim().toUpperCase();
    if (!code) return showToast("Please enter a coupon code.", 'error');
    if (!coupons[code]) return showToast("Invalid coupon code", 'error');
    if (usedCoupons.includes(code)) return showToast("You already used this coupon.", 'error');

    couponApplied = coupons[code];
    usedCoupons.push(code);
    localStorage.setItem("usedCoupons", JSON.stringify(usedCoupons));
    showToast(`Coupon applied: ${code}`);
    render();
  });

  // --- Save address ---
  if (userAddressEl) {
    userAddressEl.addEventListener("blur", () => {
      const val = userAddressEl.textContent.trim();
      localStorage.setItem("deliveryAddress", val);
    });
  }

  // --- Helper for API path ---
  const getApiPath = (endpoint) => {
    const base = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '');
    return base + 'api/' + endpoint;
  };

  // --- Address Logic ---
  function saveAddressToDB(address) {
    fetch(getApiPath("save_address.php"), {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "address=" + encodeURIComponent(address)
    })
      .then(res => res.text()) // legacy api might return text or json
      .catch(err => console.error("DB Save Error:", err));
  }

  function loadAddressFromServer() {
    fetch(getApiPath('get_address.php'), { credentials: 'same-origin' })
      .then(r => r.json())
      .then(data => {
        if (data.ok && data.address) {
          const el = document.getElementById('userAddress');
          if (el) el.textContent = data.address;
          localStorage.setItem('deliveryAddress', data.address);
        }
      })
      .catch(err => console.log('Address load info:', err));
  }

  // Call load on start
  loadAddressFromServer();

  window.detectLocation = function () { // Expose globally if needed by onclick
    if (userAddressEl) userAddressEl.textContent = "Detecting location...";

    if (!navigator.geolocation) {
      showToast("Geolocation not supported.", 'error');
      if (userAddressEl) userAddressEl.textContent = "Location not supported";
      return;
    }

    navigator.geolocation.getCurrentPosition((position) => {
      const lat = position.coords.latitude;
      const lon = position.coords.longitude;

      // Save location for distance calcs
      localStorage.setItem('userLat', lat);
      localStorage.setItem('userLon', lon);

      showToast("Location detected!", 'success');

      // Reload venues if we are on the dashboard
      loadVenues();

      fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
        .then(response => response.json())
        .then(data => {
          const address = data.display_name || `Lat: ${lat}, Lon: ${lon}`;
          if (userAddressEl) {
            userAddressEl.textContent = address;
          }
          localStorage.setItem("deliveryAddress", address);
          saveAddressToDB(address);
          showToast("Address updated!");
        })
        .catch(err => {
          console.error("Error fetching address:", err);
          if (userAddressEl) userAddressEl.textContent = `Lat: ${lat}, Lon: ${lon}`;
        });
    }, (err) => {
      console.warn("Unable to retrieve location.", err);
      showToast("Unable to retrieve location.", 'error');
      if (userAddressEl) userAddressEl.textContent = "Location access denied";
    });
  }

  // --- Load Venues (Nearby) ---
  function loadVenues() {
    const container = document.getElementById('nearby-venues');
    if (!container) return;

    const section = document.getElementById('nearby-section');

    const userLat = parseFloat(localStorage.getItem('userLat'));
    const userLon = parseFloat(localStorage.getItem('userLon'));

    fetch(getApiPath('get_venues.php'))
      .then(r => r.json())
      .then(data => {
        if (data.ok && data.venues.length > 0) {
          let venues = data.venues;

          // Calculate distance if location known
          if (!isNaN(userLat) && !isNaN(userLon)) {
            venues = venues.map(v => {
              v.distance = getDistanceFromLatLonInKm(userLat, userLon, v.latitude || userLat + 0.01, v.longitude || userLon + 0.01);
              return v;
            }).sort((a, b) => a.distance - b.distance);
          }

          container.innerHTML = venues.map(v => `
                      <div class="gallery-card" onclick="window.location.href='pages/venue.php?id=${v.id}'" style="cursor:pointer">
                           <div class="gallery-img-wrapper">
                               <img src="${v.image.startsWith('http') ? v.image : 'assets/images/' + v.image}" alt="${v.name}" onerror="this.src='assets/images/image 6.jpg'">
                               <div style="position:absolute; bottom:10px; left:10px; background:rgba(0,0,0,0.7); color:white; padding:4px 8px; border-radius:4px; font-size:12px;">
                                   ${v.distance ? v.distance.toFixed(1) + ' km' : 'Nearby'}
                               </div>
                           </div>
                           <div class="gallery-details">
                               <div class="gallery-name">${v.name}</div>
                               <div style="font-size:13px; color:#888;">${v.type === 'hostel' ? '🏠' : '🍽️'} ${ucFirst(v.type)} • ⭐ ${v.rating}</div>
                               <div style="font-size:12px; color:#aaa; margin-top:4px;">${v.address}</div>
                           </div>
                      </div>
                  `).join('');

          section.style.display = 'block';
        }
      })
      .catch(e => console.error("Error loading venues", e));
  }

  function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
    if (!lat2 || !lon2) return 0;
    var R = 6371; // Radius of the earth in km
    var dLat = deg2rad(lat2 - lat1);  // deg2rad below
    var dLon = deg2rad(lon2 - lon1);
    var a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
      Math.sin(dLon / 2) * Math.sin(dLon / 2)
      ;
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c; // Distance in km
    return d;
  }

  function deg2rad(deg) {
    return deg * (Math.PI / 180)
  }

  function ucFirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  // Load venues on start
  loadVenues();

  // --- Checkout ---
  checkoutBtn && checkoutBtn.addEventListener("click", () => {
    const subtotal = Object.keys(cart).reduce((s, k) => s + cart[k].price * cart[k].qty, 0);
    if (subtotal <= 0) return showToast("Your cart is empty.", 'error');
    const addr = userAddressEl ? userAddressEl.textContent.trim() : "";
    if (!addr || addr === "Detecting location..." || addr === "Location access denied") return showToast("Please enter delivery address.", 'error');

    const totals = computeTotals();

    // Prepare payload
    const payload = {
      cart: cart,
      total: totals.total,
      address: addr
    };

    // Call API
    fetch(getApiPath('create_order.php'), {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    })
      .then(r => r.json())
      .then(data => {
        if (data.ok) {
          const modalBody = modal.querySelector(".glass");
          // Inject Animation
          modalBody.innerHTML = `
                  <div class="checkmark-wrapper">
                      <svg class="checkmark-circle" viewBox="0 0 52 52">
                          <circle cx="26" cy="26" r="25" fill="none"/>
                          <path class="checkmark-check" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                      </svg>
                  </div>
                  <h2>Order Placed!</h2>
                  <p style="margin:20px 0; color:#666;">Order #${data.orderId} placed successfully!<br>Total ${rs(totals.total)}.</p>
                  <button id="closeConfirm" class="add-btn" style="font-size:16px; padding:10px 30px;">Awesome</button>
              `;

          // Re-bind close button since we overwrote HTML
          document.getElementById("closeConfirm").addEventListener("click", () => {
            modal.style.display = "none";
            modal.setAttribute("aria-hidden", "true");
          });

          modal.style.display = "flex";
          modal.setAttribute("aria-hidden", "false");

          // Clear Cart
          cart = {};
          localStorage.removeItem("shoppingCart");
          couponApplied = null;
          render();
          // Show side notification too
          showToast("Order placed successfully!", 'success');
        } else {
          showToast("Failed to place order: " + (data.msg || "Unknown error"), 'error');
          if (data.msg === 'User not logged in') {
            window.location.href = getApiPath('../pages/login.php');
          }
        }
      })
      .catch(err => {
        console.error('Checkout error:', err);
        showToast("Error placing order.", 'error');
      });
  });

  // --- Close modal (Initial bind) ---
  closeConfirm && closeConfirm.addEventListener("click", () => {
    modal.style.display = "none";
    modal.setAttribute("aria-hidden", "true");
  });



  // --- Initial render ---
  // Ensure we render the cart on load, so stored items appear
  render();

  // --- Dark Mode Logic ---
  window.toggleTheme = function () {
    const current = document.documentElement.getAttribute('data-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);

    const themeText = document.getElementById('themeText');
    if (themeText) themeText.textContent = next === 'dark' ? 'Light Mode' : 'Dark Mode';

    const themeIcon = document.getElementById('themeIcon');
    if (themeIcon) themeIcon.className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';

    showToast(`${next === 'dark' ? 'Dark' : 'Light'} mode activated!`);
  }

  // Set initial text if on profile page
  const savedTheme = localStorage.getItem('theme') || 'light';
  const themeText = document.getElementById('themeText');
  const themeIcon = document.getElementById('themeIcon');
  if (themeText) themeText.textContent = savedTheme === 'dark' ? 'Light Mode' : 'Dark Mode';
  if (themeIcon) themeIcon.className = savedTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';

  // --- Scroll Animation ---
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('scroll-show');
      }
    });
  }, { threshold: 0.1 });

  // Observe existing cards
  document.querySelectorAll('.gallery-card, .order-card').forEach(el => {
    el.classList.add('scroll-hidden');
    observer.observe(el);
  });

  // Observe dynamically added searches
  const resultContainer = document.querySelector('.result-container');
  if (resultContainer) {
    const config = { childList: true };
    const callback = function (mutationsList, observer) {
      for (const mutation of mutationsList) {
        if (mutation.type === 'childList') {
          mutation.addedNodes.forEach(node => {
            if (node.classList && (node.classList.contains('gallery-card') || node.classList.contains('result-item'))) {
              node.classList.add('scroll-hidden');
              // small delay for stagger effect
              setTimeout(() => node.classList.add('scroll-show'), 100);
            }
          });
        }
      }
    };
    const mutationObserver = new MutationObserver(callback);
    mutationObserver.observe(resultContainer, config);
  }

  // --- Empty State Handler for Index/Search ---
  const gallery = document.querySelector('.gallery');
  if (gallery && gallery.children.length === 0) {
    gallery.innerHTML = `
        <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-muted);">
            <i class="fas fa-utensils" style="font-size: 48px; margin-bottom: 20px; opacity: 0.5;"></i>
            <h3>No dishes found</h3>
            <p>Check back later or try a different category!</p>
        </div>
      `;
  }

  // --- Sidebar & Cart Toggle Logic ---
  // Create overlay if not exists
  let overlay = document.querySelector('.sidebar-overlay');
  if (!overlay) {
    overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);
  }

  // Menu Toggle (Left)
  if (menuBtn && sidebar) {
    menuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      cartPanel && cartPanel.classList.remove('active'); // Close cart if open
      overlay.classList.toggle('active');
    });
  }

  // Cart Toggle (Right) - Use cartIcon defined at top
  if (cartIcon && cartPanel) {
    cartIcon.addEventListener('click', (e) => {
      e.preventDefault(); // Prevent label default
      cartPanel.classList.toggle('active');
      sidebar && sidebar.classList.remove('active'); // Close menu if open
      overlay.classList.toggle('active');
      render(); // Ensuring render is called when opening
    });
  }

  // Overlay Click (Close specific)
  overlay.addEventListener('click', () => {
    sidebar && sidebar.classList.remove('active');
    cartPanel && cartPanel.classList.remove('active');
    overlay.classList.remove('active');
  });
  // --- Favorites Functionality ---
  let favorites = JSON.parse(localStorage.getItem("favorites")) || [];

  // Save favorites to localStorage
  function saveFavorites() {
    localStorage.setItem("favorites", JSON.stringify(favorites));
    updateHeartIcons();
    // If we are on the favorites page, re-render
    if (window.location.pathname.includes('favorites.php')) {
      renderFavoritesPage();
    }
  }

  // Toggle Favorite Status
  function toggleFavorite(name, price, image) {
    const existingIndex = favorites.findIndex(item => item.name === name);

    if (existingIndex > -1) {
      // Remove
      favorites.splice(existingIndex, 1);
      showToast(`${name} removed from favorites`);
    } else {
      // Add
      favorites.push({ name, price, image });
      showToast(`${name} added to favorites!`);
    }

    saveFavorites();
  }

  // Update Heart Icons on the page based on state
  function updateHeartIcons() {
    const heartWrappers = document.querySelectorAll('.gallery-img-wrapper div');

    heartWrappers.forEach(wrapper => {
      // Try to find the associated item name
      const card = wrapper.closest('.gallery-card');
      if (!card) return;

      const name = card.querySelector('.gallery-name').innerText;
      const icon = wrapper.querySelector('i');

      const isFav = favorites.some(item => item.name === name);

      if (isFav) {
        icon.classList.remove('far'); // Outline
        icon.classList.add('fas'); // Solid
      } else {
        icon.classList.remove('fas'); // Solid
        icon.classList.add('far'); // Outline
      }
    });
  }

  // Render Favorites Page (only runs if container exists)
  function renderFavoritesPage() {
    const container = document.getElementById('favorites-gallery');
    if (!container) return; // Not on favorites page

    if (favorites.length === 0) {
      container.innerHTML = `
            <div class="empty-state" style="grid-column: 1/-1; text-align: center; color: #888; margin-top: 50px;">
                <i class="fas fa-heart-broken" style="font-size: 50px; margin-bottom: 20px; opacity: 0.5;"></i>
                <p>No favorites yet!</p>
                <a href="../index.php" style="color:var(--primary); text-decoration:underline;">Browse Food</a>
            </div>
        `;
      return;
    }

    container.innerHTML = favorites.map(item => `
        <div class="gallery-card">
            <div class="gallery-img-wrapper">
                <img src="${item.image}" alt="${item.name}" onerror="this.src='../assets/images/image 1.jpg'">
                <div class="fav-btn" data-name="${item.name}" data-price="${item.price}" data-image="${item.image}"
                     style="position:absolute; top:10px; right:10px; background:white; padding:5px; border-radius:50%; cursor:pointer; width:30px; height:30px; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 5px rgba(0,0,0,0.2);">
                    <i class="fas fa-heart" style="color:#ff3b30; font-size:16px;"></i>
                </div>
            </div>
            <div class="gallery-details">
                <div class="gallery-name">${item.name}</div>
                <div class="gallery-footer">
                    <span style="font-weight:600; color: #888;">Rs.${item.price}</span>
                    <button class="add-btn" data-price="${item.price}">Add +</button>
                </div>
            </div>
        </div>
    `).join('');
  }

  // Global Event Listener for Favorites (Delegation)
  document.body.addEventListener('click', function (e) {
    // Check if clicked element is inside the heart container
    let heartBtn = e.target.closest('.gallery-img-wrapper > div');

    // Also handle fav-btn class explicitly if we used it
    if (!heartBtn && e.target.closest('.fav-btn')) heartBtn = e.target.closest('.fav-btn');

    if (heartBtn && heartBtn.querySelector('.fa-heart')) {
      const card = heartBtn.closest('.gallery-card');
      if (!card) return;

      const name = card.querySelector('.gallery-name').innerText;
      // Need to clean price string (remove Rs., $, whitespace)
      const priceEl = card.querySelector('.gallery-footer span');
      const priceStr = priceEl ? priceEl.innerText : "0";
      const price = parseFloat(priceStr.replace(/[^0-9.]/g, ''));
      const image = card.querySelector('img').src;

      toggleFavorite(name, price, image);
    }
  });

  // Initial calls
  updateHeartIcons();
  renderFavoritesPage();

});
