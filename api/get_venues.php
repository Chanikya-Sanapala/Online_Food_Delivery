<?php
require '../includes/config.php';
header('Content-Type: application/json');

$sql = "SELECT * FROM venues";
$result = $conn->query($sql);

$venues = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $venues[] = $row;
    }
}

echo json_encode(['ok' => true, 'venues' => $venues]);
?>
