<?php
session_start();
require '../includes/config.php';

if (!isset($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$venue_id = intval($_GET['id']);
$sql = "SELECT * FROM venues WHERE id = $venue_id";
$result = $conn->query($sql);
$venue = $result->fetch_assoc();

if (!$venue) {
    echo "Venue not found.";
    exit();
}

$base_path = '../';
$activePage = 'home';
require '../includes/header.php';
require '../includes/sidebar.php';
?>

<div class="dashboard">
    <div class="dashboard-banner" style="height: 250px;">
        <img src="../assets/images/<?php echo htmlspecialchars($venue['image']); ?>" alt="<?php echo htmlspecialchars($venue['name']); ?>" onerror="this.src='../assets/images/restaurant_chinese.jpg'">
        <div class="banner-promo">
            <h1><?php echo htmlspecialchars($venue['name']); ?></h1>
            <div class="promo-sub" style="font-size:16px;">
                <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($venue['address']); ?> <br>
                Type: <?php echo ucfirst($venue['type']); ?> • Rating: <?php echo $venue['rating']; ?> ⭐
            </div>
        </div>
    </div>

    <h3 class="dashboard-title">Menu</h3>
    <div class="gallery">
       <?php
       $sql = "SELECT * FROM menu_items WHERE venue_id = $venue_id";
       $result = $conn->query($sql);
       if ($result && $result->num_rows > 0) {
           while($row = $result->fetch_assoc()) {
               $imgVal = htmlspecialchars($row['image']);
               $image = (strpos($imgVal, 'http') === 0) ? $imgVal : '../assets/images/' . $imgVal;
               echo '
               <div class="gallery-card">
                   <div class="gallery-img-wrapper">
                       <img src="'.$image.'" alt="'.htmlspecialchars($row['name']).'" onerror="this.src=\'../assets/images/image 1.jpg\'">
                       <div class="fav-btn" data-name="'.htmlspecialchars($row['name']).'" data-price="'.$row['price'].'" data-image="'.$image.'"
                            style="position:absolute; top:10px; right:10px; background:white; padding:5px; border-radius:50%; cursor:pointer; width:30px; height:30px; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 5px rgba(0,0,0,0.2);">
                           <i class="far fa-heart" style="color:#ff3b30; font-size:16px;"></i>
                       </div>
                   </div>
                   <div class="gallery-details">
                       <div class="gallery-name">'.htmlspecialchars($row['name']).'</div>
                       <div style="font-size:13px; color:#888; margin-bottom:10px;">'.htmlspecialchars($row['description']).'</div>
                       <div class="gallery-footer">
                           <span style="font-weight:600; color: #888;">Rs.'.htmlspecialchars($row['price']).'</span>
                           <button class="add-btn" data-price="'.$row['price'].'">Add +</button>
                       </div>
                   </div>
               </div>';
           }
       } else {
           echo '<p>No menu items found for this venue.</p>';
       }
       ?>
    </div>
</div>

<?php require '../includes/cart.php'; ?>
<script src="../assets/js/script.js"></script>
</body>
</html>
