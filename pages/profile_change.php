<?php
session_start();
require '../includes/config.php';

// Auth Check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    // Email is read-only usually, but if allowed: $email = $_POST['email'];
    $address = $_POST['address'];
    
    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, address=? WHERE id=?");
    $stmt->bind_param("sssi", $first_name, $last_name, $address, $user_id);
    
    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
        // Update session vars if needed
        $_SESSION['first_name'] = $first_name; 
    } else {
        $message = "Error updating profile.";
    }
    $stmt->close();
}

// Fetch current info
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$stmt->close();

// Prepare for View
$base_path = '../';
$activePage = 'profile'; // Highlight profile key
require '../includes/header.php';
require '../includes/sidebar.php';
?>

<div class="dashboard">
    <div style="max-width: 600px; margin: 0 auto;">
        
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
            <a href="profile.php" class="back-btn" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center; background:var(--card-bg); border-radius:50%; box-shadow:var(--shadow);">
                <i class="fas fa-arrow-left" style="color:var(--primary);"></i>
            </a>
            <h3 class="dashboard-title" style="margin: 0;">Edit Profile</h3>
        </div>

        <?php if($message): ?>
            <div style="background: #4cd964; color: white; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="glass" style="padding: 30px; border-radius: 20px; background: var(--card-bg);">
            <form action="" method="POST">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-muted);">First Name</label>
                    <input type="text" name="fname" value="<?php echo htmlspecialchars($user['first_name']); ?>" required
                        style="width: 100%; padding: 12px; border: 1px solid var(--border-color); background: var(--input-bg); color: var(--text-color); border-radius: 12px; outline:none;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-muted);">Last Name</label>
                    <input type="text" name="lname" value="<?php echo htmlspecialchars($user['last_name']); ?>" required
                        style="width: 100%; padding: 12px; border: 1px solid var(--border-color); background: var(--input-bg); color: var(--text-color); border-radius: 12px; outline:none;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-muted);">Email Address</label>
                    <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly
                        style="width: 100%; padding: 12px; border: 1px solid var(--border-color); background: rgba(0,0,0,0.05); color: var(--text-muted); border-radius: 12px; outline:none; cursor: not-allowed;">
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-muted);">Delivery Address</label>
                    <textarea name="address" rows="3" placeholder="Enter your full address"
                        style="width: 100%; padding: 12px; border: 1px solid var(--border-color); background: var(--input-bg); color: var(--text-color); border-radius: 12px; outline:none; resize:none; font-family:inherit;"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                </div>

                <button type="submit" class="checkout-btn">Save Changes</button>
            </form>
        </div>

    </div>
</div>

<?php require '../includes/cart.php'; ?>
<script src="../assets/js/script.js"></script>
</body>
</html>