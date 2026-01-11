// Example favorites data
const favorites = [
  {
    name: "Spicy Chicken Burger",
    restaurant: "Burger Palace",
    rating: 4.5,
    price: "₹199",
    img: "image 1.jpg",
  },
  {
    name: "Paneer Tikka Pizza",
    restaurant: "Pizza Planet",
    rating: 4.2,
    price: "₹299",
    img: "ice cream.jpeg",
  },
  {
    name: "Chicken Biryani",
    restaurant: "Biryani House",
    rating: 4.7,
    price: "₹249",
    img: "Chicken-Biryani.webp",
  },
];

// Render favorites dynamically
function renderFavorites() {
  const container = document.getElementById("favorites-container");
  container.innerHTML = "";

  if (favorites.length === 0) {
    container.innerHTML = `<p>No favorites yet 😔</p>`;
    return;
  }

  favorites.forEach((item, index) => {
    const card = document.createElement("div");
    card.classList.add("gallery-card");

    card.innerHTML = `
      <div class="gallery-img-wrapper">
        <img src="${item.img}" alt="${item.name}">
      </div>
      <div class="gallery-details">
        <div class="gallery-name">${item.name}</div>
        <div style="font-size: 13px; color: #888; margin-bottom: 5px;">${item.restaurant}</div>
        <div class="gallery-footer">
            <span style="font-weight:600; color: #888;">${item.price}</span>
            <button class="add-btn" style="background:#ff3b30" onclick="removeFavorite(${index})">Remove</button>
        </div>
      </div>
    `;

    container.appendChild(card);
  });
}

// Remove item from favorites
function removeFavorite(index) {
  favorites.splice(index, 1);
  renderFavorites();
}

// Optional dark mode toggle from your main app
document.addEventListener("keydown", (e) => {
  if (e.key === "d") document.body.classList.toggle("dark-mode");
});

// Load favorites initially
renderFavorites();
