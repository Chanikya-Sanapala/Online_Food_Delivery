const foodItems = [
  { name: "Chicken Biryani", image: "Chicken-Biryani.webp", price: 149 },
  { name: "Pizza", image: "pizza.jpg", price: 199 },
  { name: "Fried Rice", image: "fried rice.webp", price: 99 },
  { name: "Dosa", image: "dasa.jpg", price: 60 },
  { name: "Burger", image: "image 6.jpg", price: 120 },
  { name: "Cake", image: "cake.jpeg", price: 250 },
  { name: "Momos", image: "momos.jpg", price: 80 },
];

function performSearch() {
  const query = document.getElementById("searchBox").value.toLowerCase();
  const resultsDiv = document.getElementById("results");
  resultsDiv.innerHTML = "";

  const results = foodItems.filter(item => item.name.toLowerCase().includes(query));

  if (results.length === 0) {
    resultsDiv.innerHTML = "<p>No results found 😢</p>";
    return;
  }

  results.forEach(item => {
    const div = document.createElement("div");
    div.classList.add("result-item");
    div.innerHTML = `
      <img src="${item.image}" alt="${item.name}">
      <div>
        <p><b>${item.name}</b></p>
        <p>₹${item.price}</p>
      </div>
    `;
    resultsDiv.appendChild(div);
  });
}
