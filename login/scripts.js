// Example user data (you can replace this with API call or localStorage)
const userData = {
  name: "Chanikya",
  email: "sanapalachanikya@gmail.com",
  membership: "Gold Member",
  savings: 187,
  wallet: 120,
  progress: 80,
  rating: 5,
};

// Dynamically update profile data
function updateProfile(data) {
  document.getElementById("username").textContent = data.name;
  document.getElementById("email").textContent = data.email;
  document.getElementById("membership").textContent = data.membership;
  document.getElementById("savings").textContent = `Saved ₹${data.savings}`;
  document.getElementById("wallet").textContent = `Money ₹${data.wallet}`;
  document.getElementById("progress").textContent = `${data.progress}% completed`;
  document.getElementById("rating").textContent = data.rating.toFixed(2);

  // Avatar = first letter of name
  const avatar = document.getElementById("avatar");
  avatar.textContent = data.name.charAt(0).toUpperCase();

  // Membership badge color
  const badge = document.getElementById("membership");
  badge.classList.remove("gold-member", "silver-member", "bronze-member");
  if (data.membership.toLowerCase().includes("gold")) badge.classList.add("gold-member");
  else if (data.membership.toLowerCase().includes("silver")) badge.classList.add("silver-member");
  else badge.classList.add("bronze-member");
}

// Call function to render data
updateProfile(userData);

// Dark mode toggle
document.getElementById("dark-mode-toggle").addEventListener("click", (e) => {
  e.preventDefault();
  document.body.classList.toggle("dark-mode");
});
