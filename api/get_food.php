<?php
// Suppress warnings/notices so they don't break JSON
error_reporting(0);
header('Content-Type: application/json');

require '../includes/config.php';

// Check connection manually to avoid die() in config if we can help it 
// (assuming config doesn't die instantly, but it has a die()... 
// If config dies, it outputs text. JS will catch it as invalid JSON. 
// Ideally config shouldn't die, but we can't change it easily if it's shared.
// We'll proceed assuming config works or output is captured.)

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$query = isset($_GET['q']) ? $_GET['q'] : '';
$sql = "SELECT * FROM menu_items";
if($query) {
   $q = $conn->real_escape_string($query);
   $sql .= " WHERE name LIKE '%$q%' OR description LIKE '%$q%'";
}

$result = $conn->query($sql);
$items = [];

if ($result) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

echo json_encode($items);
?>
