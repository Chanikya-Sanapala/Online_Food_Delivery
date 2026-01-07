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
    card.classList.add("fav-card");

    card.innerHTML = `
      <img src="${item.img}" alt="${item.name}" class="fav-img" />
      <div class="fav-content">
        <h3>${item.name}</h3>
        <p>${item.restaurant}</p>
        <p><span class="rating">⭐ ${item.rating}</span> • <span class="price">${item.price}</span></p>
        <button class="remove-btn" onclick="removeFavorite(${index})">Remove</button>
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
