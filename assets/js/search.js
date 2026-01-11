
document.addEventListener("DOMContentLoaded", () => {
  const searchBox = document.getElementById("searchBox");
  // Perform search on every keystroke
  searchBox.addEventListener("input", performSearch);

  // Initial fetch
  performSearch();
});

async function performSearch() {
  const query = document.getElementById("searchBox").value.trim();
  const resultsDiv = document.getElementById("results");

  // Default URL relative to where this script is used
  // If used in pages/search.php (BASE_PATH='../'), api is '../api/get_food.php'
  // If used in index.php (BASE_PATH=''), api is 'api/get_food.php'
  const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/get_food.php';

  try {
    const url = query ? `${apiPath}?q=${encodeURIComponent(query)}` : apiPath;
    const response = await fetch(url);
    const items = await response.json();

    renderResults(items, query);
  } catch (error) {
    console.error("Error fetching items:", error);
    resultsDiv.innerHTML = `<p style="text-align:center; color:red;">Unable to load items.</p>`;
  }
}

function renderResults(items, query) {
  const resultsDiv = document.getElementById("results");
  resultsDiv.innerHTML = "";

  if (items.length === 0) {
    resultsDiv.innerHTML = `
          <div class="empty-state">
              <i class="fas fa-cookie-bite"></i>
              <p>No delicious food found${query ? ' matching "' + query + '"' : ''}</p>
          </div>`;
    return;
  }

  // Assuming images are in assets/images/
  const imgBase = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'assets/images/';

  items.forEach(item => {
    const div = document.createElement("div");
    div.classList.add("gallery-card");
    div.style.animation = "fadeScale 0.4s ease-out";

    // Fallback image if null
    const imgSrc = item.image ? (imgBase + item.image) : (imgBase + 'placeholder.jpg');

    div.innerHTML = `
        <div class="gallery-img-wrapper">
          <img src="${imgSrc}" alt="${item.name}" onerror="this.src='${imgBase}image 1.jpg'">
        </div>
        <div class="gallery-details">
          <div class="gallery-name">${item.name}</div>
          <div class="gallery-footer">
              <span style="font-weight:600; color: #888;">Rs.${item.price}</span>
              <button class="add-btn" data-price="${item.price}">Add +</button>
          </div>
        </div>
      `;
    resultsDiv.appendChild(div);
  });

  // Re-bind add buttons since they are dynamic
  // But script.js uses document.addEventListener on load... 
  // We need to delegate or re-bind. 
  // script.js actually binds specific elements: const addButtons = document.querySelectorAll...
  // We should trigger a re-bind or use event delegation.
  // However, for this task, I'll assume we need to handle the click here OR modify script.js to use delegation.
  // Modifying script.js to use delegation is the BEST approach. I will do that in next step.
  // For now, I'll manually dispatch a custom event or just let it be, but the buttons won't work without delegation.
}
