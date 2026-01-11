<?php
session_start();
// If needed, check login
// if (!isset($_SESSION['user_id'])) { ... }

$base_path = '../';
$activePage = 'search';
$extra_css = '<link rel="stylesheet" href="../assets/css/search.css?v=' . time() . '">';
require '../includes/header.php';
require '../includes/sidebar.php';
?>

<!-- Main Content -->
<div class="dashboard">
  <h3 class="dashboard-title">Find Your Food</h3>

  <!-- Search Bar -->
  <div class="search-container" style="margin-bottom: 30px;">
    <input type="text" id="searchBox" placeholder="Search for food..."
      style="width: 100%; padding: 15px; border-radius: 99px; border: 1px solid #ddd; outline: none; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
    <button onclick="performSearch()" style="display:none;">Search</button>
  </div>

  <!-- Suggested Results Grid -->
  <div id="results" class="gallery">
    <!-- Results injected here by search.js -->
    <div class="empty-state" style="grid-column: 1/-1; text-align: center; color: #888; margin-top: 50px;">
      <i class="fas fa-search" style="font-size: 50px; margin-bottom: 20px; opacity: 0.5;"></i>
      <p>Type above to search...</p>
    </div>
  </div>
</div>

<?php 
// Include cart if you want cart on search page too
require '../includes/cart.php'; 
?>

<script src="../assets/js/search.js"></script>
<script src="../assets/js/script.js"></script> <!-- Core script for cart logic -->
</body>
</html>