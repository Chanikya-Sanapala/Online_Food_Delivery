<?php
session_start();
require '../includes/config.php';
// Auth Check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$base_path = '../';
$activePage = 'favorites';
require '../includes/header.php';
require '../includes/sidebar.php';
?>

<div class="dashboard">
  <h3 class="dashboard-title">Your Favorites</h3>
  
  <div class="gallery" id="favorites-gallery">
      <!-- Content rendered by JS -->
  </div>
</div>

<?php require '../includes/cart.php'; ?>
<script src="../assets/js/script.js"></script>
</body>
</html>