<?php
session_start();
require '../includes/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$base_path = '../';
$activePage = 'profile'; // Keep profile active
require '../includes/header.php';
require '../includes/sidebar.php';
?>

<div class="dashboard">
    <h3 class="dashboard-title">My Orders</h3>
    
    <div class="order-history" style="padding-bottom: 80px;">
        <?php
        $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($order = $result->fetch_assoc()) {
                $orderId = $order['id'];
                $status = ucfirst($order['status']);
                $total = $order['final_amount'];
                $date = date("M d, Y h:i A", strtotime($order['created_at']));
                
                // Status color
                $statusColor = '#888';
                if($status == 'Pending') $statusColor = 'orange';
                if($status == 'Confirmed') $statusColor = 'blue';
                if($status == 'Delivered') $statusColor = 'green';
                
                // Fetch items
                $itemsSql = "SELECT * FROM order_items WHERE order_id = $orderId";
                $itemsRes = $conn->query($itemsSql);
                $itemsStr = [];
                while($item = $itemsRes->fetch_assoc()) {
                    $itemsStr[] = $item['quantity'] . "x " . $item['item_name'];
                }
                $itemsDisplay = implode(", ", $itemsStr);

                echo "
                <div class='gallery-card' style='display:block; width:100%; margin-bottom:15px; padding:15px; height:auto;'>
                    <div style='display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;'>
                        <h4 style='margin:0;'>Order #$orderId</h4>
                        <span style='background:$statusColor; color:white; padding:4px 10px; border-radius:12px; font-size:12px;'>$status</span>
                    </div>
                    <p style='color:#666; font-size:13px; margin:5px 0;'>$date</p>
                    <p style='color:#333; font-weight:500;'>$itemsDisplay</p>
                    <hr style='border:0; border-top:1px solid #eee; margin:10px 0;'>
                    <div style='display:flex; justify-content:space-between;'>
                        <span>Total</span>
                        <span style='font-weight:bold;'>Rs.$total</span>
                    </div>
                </div>";
            }
        } else {
            echo "<p style='text-align:center; color:#888; margin-top:50px;'>No orders found.</p>";
        }
        $stmt->close();
        ?>
    </div>
</div>

<script src="../assets/js/script.js"></script>
</body>
</html>
