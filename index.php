<?php
session_start();
require 'includes/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}
$base_path = '';
$activePage = 'home';
require 'includes/header.php';
require 'includes/sidebar.php';
?>

<!-- Main Content -->
<div class="dashboard">
  <div class="dashboard-banner">
    <video autoplay muted loop playsinline poster="assets/images/banner-placeholder.jpg">
      <source src="assets/videos/banner.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
    <div class="banner-promo">
      <h1>Delicious Food<br><span>Delivered To You</span></h1>
    </div>
  </div>

<h3 class="dashboard-title">Categories</h3>
<div class="dashboard-menu">
  <a href="#explore-section" class="active">All</a>
  <a href="#popular-section">Popular</a>
  <a href="#nearby-section">Near Me</a>
  <a href="#promotion-section">Promotion</a>
  <a href="#top-rated-section">Top Rated</a>
</div>

<div class="scroll-container">
  <!-- Ensure these images exist in assets or update paths -->
  <img src="https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=200&h=200&fit=crop" alt="Biryani">
  <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?w=200&h=200&fit=crop" alt="Pizza">
  <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=200&h=200&fit=crop" alt="Burger">
  <img src="https://images.unsplash.com/photo-1626074353765-517a681e40be?w=200&h=200&fit=crop" alt="Chicken">
  <img src="https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=200&h=200&fit=crop" alt="Dessert">
  <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=200&h=200&fit=crop" alt="Healthy">
  <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=200&h=200&fit=crop" alt="Asian">
  <img src="https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=200&h=200&fit=crop" alt="Sandwich">
  <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=200&h=200&fit=crop" alt="Salad">
  <img src="https://images.unsplash.com/photo-1498837167922-ddd27525d352?w=200&h=200&fit=crop" alt="Breakfast">
  <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=200&h=200&fit=crop" alt="Coffee">
  <img src="https://images.unsplash.com/photo-1623653387945-2fd25214f8fc?w=200&h=200&fit=crop" alt="Juice">
  <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=200&h=200&fit=crop" alt="Cake">
  <img src="https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?w=200&h=200&fit=crop" alt="Dessert2">
</div>

    <!-- Section: Nearby Venues (Rendered by JS) -->
    <div id="nearby-section" style="display:none; margin-bottom:30px; scroll-margin-top: 100px;">
        <h3 class="dashboard-title">Restaurants & Hostels 📍</h3>
        <div class="gallery" id="nearby-venues"></div>
    </div>

    <!-- Section: Explore Food -->
    <div id="explore-section" style="display:flex; justify-content:space-between; align-items:center; margin-top:20px; scroll-margin-top: 100px;">
        <h3 class="dashboard-title">Explore Food 🥘</h3>
    </div>
    <div class="gallery" style="margin-bottom: 40px; display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px;">
       <?php
       // Show ALL menu items
       $sql = "SELECT * FROM menu_items ORDER BY id DESC";
       $result = $conn->query($sql);
       if ($result) {
           while($row = $result->fetch_assoc()) {
               $image = 'assets/images/' . htmlspecialchars($row['image']);
               echo '
               <div class="gallery-card">
                   <div class="gallery-img-wrapper">
                       <img src="'.$image.'" alt="'.htmlspecialchars($row['name']).'" onerror="this.src=\'assets/images/image 1.jpg\'">
                       <div style="position:absolute; top:10px; right:10px; background:white; padding:5px; border-radius:50%; cursor:pointer; width:30px; height:30px; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 5px rgba(0,0,0,0.2);">
                           <i class="far fa-heart" style="color:#ff3b30; font-size:16px;"></i>
                       </div>
                   </div>
                   <div class="gallery-details">
                       <div class="gallery-name">'.htmlspecialchars($row['name']).'</div>
                       <div class="gallery-footer">
                           <span style="font-weight:600; color: #888;">Rs.'.htmlspecialchars($row['price']).'</span>
                           <button class="add-btn" data-price="'.$row['price'].'">Add +</button>
                       </div>
                   </div>
               </div>';
           }
       }
       ?>
    </div>

    <!-- Section: Near Me -->
    <h3 class="dashboard-title">Near Me</h3>
    <div class="gallery" style="margin-bottom: 40px;">
       <?php
       // Simulation: Select random items
       $sql = "SELECT * FROM menu_items ORDER BY RAND() LIMIT 4";
       $result = $conn->query($sql);
       if ($result) {
           while($row = $result->fetch_assoc()) {
               $image = 'assets/images/' . htmlspecialchars($row['image']);
               echo '
               <div class="gallery-card">
                   <div class="gallery-img-wrapper">
                       <img src="'.$image.'" alt="'.htmlspecialchars($row['name']).'" onerror="this.src=\'assets/images/image 1.jpg\'">
                   </div>
                   <div class="gallery-details">
                       <div class="gallery-name">'.htmlspecialchars($row['name']).'</div>
                       <p style="font-size:12px; color:#aaa; margin-bottom:5px;"><i class="fas fa-map-marker-alt"></i> 15-20 mins • 2.5km</p>
                       <div class="gallery-footer">
                           <span style="font-weight:600; color: #888;">Rs.'.htmlspecialchars($row['price']).'</span>
                           <button class="add-btn" data-price="'.$row['price'].'">Add +</button>
                       </div>
                   </div>
               </div>';
           }
       }
       ?>
    </div>

    <!-- Section: Promotions -->
    <h3 class="dashboard-title">Promotions ✨</h3>
    <div class="gallery" style="margin-bottom: 40px;">
       <?php
       // Simulation: Select items < 300
       $sql = "SELECT * FROM menu_items WHERE price < 300 LIMIT 4";
       $result = $conn->query($sql);
       if ($result) {
           while($row = $result->fetch_assoc()) {
               $image = 'assets/images/' . htmlspecialchars($row['image']);
               echo '
               <div class="gallery-card" style="border: 1px solid var(--primary);">
                   <div class="gallery-img-wrapper">
                       <img src="'.$image.'" alt="'.htmlspecialchars($row['name']).'" onerror="this.src=\'assets/images/image 1.jpg\'">
                       <div style="position:absolute; top:10px; left:10px; background:#ff3b30; color:white; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:bold;">20% OFF</div>
                   </div>
                   <div class="gallery-details">
                       <div class="gallery-name">'.htmlspecialchars($row['name']).'</div>
                       <div class="gallery-footer">
                           <span style="font-weight:600; color: #ff3b30;">Rs.'.htmlspecialchars($row['price']).'</span>
                           <button class="add-btn" data-price="'.$row['price'].'">Add +</button>
                       </div>
                   </div>
               </div>';
           }
       }
       ?>
    </div>

    <!-- Section: Top Rated -->
    <h3 class="dashboard-title">Top Rated ⭐</h3>
    <div class="gallery">
       <?php
       // Simulation: Select By ID (or just more items)
       $sql = "SELECT * FROM menu_items ORDER BY id DESC LIMIT 4";
       $result = $conn->query($sql);
       if ($result) {
           while($row = $result->fetch_assoc()) {
               $image = 'assets/images/' . htmlspecialchars($row['image']);
               echo '
               <div class="gallery-card">
                   <div class="gallery-img-wrapper">
                       <img src="'.$image.'" alt="'.htmlspecialchars($row['name']).'" onerror="this.src=\'assets/images/image 1.jpg\'">
                   </div>
                   <div class="gallery-details">
                       <div class="gallery-name">'.htmlspecialchars($row['name']).'</div>
                       <div style="color:#ffb900; font-size:12px; margin-bottom:5px;">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> (4.8)
                       </div>
                       <div class="gallery-footer">
                           <span style="font-weight:600; color: #888;">Rs.'.htmlspecialchars($row['price']).'</span>
                           <button class="add-btn" data-price="'.$row['price'].'">Add +</button>
                       </div>
                   </div>
               </div>';
           }
       }
       ?>
    </div>
</div> <!-- End Dashboard -->

<?php require 'includes/cart.php'; ?>

<script src="assets/js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>