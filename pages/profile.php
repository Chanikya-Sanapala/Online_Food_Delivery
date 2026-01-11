<?php
session_start();
require '../includes/config.php';
// Auth Check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
// Fetch latest user info
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$stmt->close();

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Fetch Stats (Mock or Real)
$ordersCount = 0;
$favCount = 0;

// Count Orders
$oStmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ?");
$oStmt->bind_param("i", $user_id);
$oStmt->execute();
$oStmt->bind_result($ordersCount);
$oStmt->fetch();
$oStmt->close();

$initials = strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1));
$fullName = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
$email = htmlspecialchars($user['email']);

$base_path = '../';
$activePage = 'profile';
require '../includes/header.php';
require '../includes/sidebar.php';
?>

  <!-- Main Content -->
  <div class="dashboard">
    <div class="profile-container">
        <!-- Modern Profile Header -->
        <div class="profile-card-modern">
            <div class="profile-avatar-large"><?php echo $initials; ?></div>
            <div style="flex:1;">
                <h2 style="margin:0; font-size:24px;"><?php echo $fullName; ?></h2>
                <p style="margin:5px 0 0; opacity:0.9;"><?php echo $email; ?></p>
                <span class="badge" style="background:rgba(255,255,255,0.2); margin-top:10px; display:inline-block;">Gold Member</span>
            </div>
            <a href="logout.php" class="btn" style="background:rgba(255,255,255,0.2); border:none;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-value"><?php echo $ordersCount; ?></span>
                <span class="stat-label">Total Orders</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">Rs. 0</span>
                <span class="stat-label">Wallet Balance</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">0</span> <!-- Placeholder for favorites count -->
                <span class="stat-label">Favorites</span>
            </div>
        </div>

        <h3 class="dashboard-title scroll-hidden">Account Settings</h3>

        <!-- Settings List -->
        <div class="profile-menu scroll-hidden">
            <a href="javascript:void(0)" onclick="toggleTheme()" style="display:flex; justify-content:space-between; align-items:center;">
                <span><i id="themeIcon" class="fas fa-moon"></i> <span id="themeText">Dark Mode</span></span>
                <div class="toggle-switch"></div>
            </a>
            <a href="profile_change.php">
                <span><i class="fas fa-user-edit"></i> Edit Personal Details</span>
                <i class="fas fa-chevron-right" style="font-size: 14px;"></i>
            </a>
            <a href="order.php">
                <span><i class="fas fa-history"></i> Order History</span>
                <i class="fas fa-chevron-right" style="font-size: 14px;"></i>
            </a>
            <a href="favorites.php">
                <span><i class="fas fa-heart"></i> Saved Items</span>
                <i class="fas fa-chevron-right" style="font-size: 14px;"></i>
            </a>
            <a href="#">
                <span><i class="fas fa-map-marker-alt"></i> Manage Addresses</span>
                <i class="fas fa-chevron-right" style="font-size: 14px;"></i>
            </a>
        </div>
    </div>
  </div>

<?php require '../includes/cart.php'; ?>
<script src="../assets/js/script.js"></script>
</body>
</html>