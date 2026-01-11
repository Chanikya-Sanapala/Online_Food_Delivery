<?php
header('Content-Type: application/json');
session_start();
require '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['ok' => false, 'msg' => 'User not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['cart'])) {
    echo json_encode(['ok' => false, 'msg' => 'Cart is empty']);
    exit;
}

$userId = $_SESSION['user_id'];
$address = $conn->real_escape_string($data['address']);
$total = floatval($data['total']);
$paymentMethod = 'cod'; // default

// Insert into orders
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, final_amount, delivery_address, payment_method) VALUES (?, ?, ?, ?, ?)");
// total_amount currently same as final_amount for simplicity
$stmt->bind_param("idsss", $userId, $total, $total, $address, $paymentMethod);

if ($stmt->execute()) {
    $orderId = $stmt->insert_id;
    $stmt->close();

    // Insert order items
    $stmtItems = $conn->prepare("INSERT INTO order_items (order_id, menu_item_id, item_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
    
    foreach ($data['cart'] as $name => $item) {
        // We need item ID. If cart only sends name, we have lookup or we should have stored ID in frontend.
        // Frontend currently sends name. We should try to lookup ID by name or just store name.
        // Our cart object has: name (key), price, qty, image.
        // ideally we should have ID.
        // For now we will insert 0 or NULL for item_id if we can't find it, but store name.
        // We will try simple lookup if we can, or just rely on name.
        // The table schema has: menu_item_id (INT NULL), item_name (VARCHAR).
        
        $qty = intval($item['qty']);
        $price = floatval($item['price']);
        $itemName = $name;
        $menuItemId = null; // or fetch user query
        
        // Optional: Lookup ID
        $res = $conn->query("SELECT id FROM menu_items WHERE name = '" . $conn->real_escape_string($itemName) . "' LIMIT 1");
        if ($res && $row = $res->fetch_assoc()) {
            $menuItemId = $row['id'];
        }

        $stmtItems->bind_param("iisid", $orderId, $menuItemId, $itemName, $qty, $price);
        $stmtItems->execute();
    }
    $stmtItems->close();

    echo json_encode(['ok' => true, 'orderId' => $orderId, 'msg' => 'Order placed successfully']);
} else {
    echo json_encode(['ok' => false, 'msg' => 'Failed to place order']);
}
?>
