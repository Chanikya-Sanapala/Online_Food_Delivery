<?php
// save_address.php
session_start();
header('Content-Type: application/json; charset=utf-8');

// require user logged in
if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['ok'=>false,'msg'=>'Not authenticated']);
  exit;
}
$user_id = intval($_SESSION['user_id']);

// Get POST data (x-www-form-urlencoded)
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$lat = isset($_POST['lat']) ? trim($_POST['lat']) : null;
$lon = isset($_POST['lon']) ? trim($_POST['lon']) : null;

if ($address === '') {
  http_response_code(400);
  echo json_encode(['ok'=>false,'msg'=>'Address required']);
  exit;
}

// DB credentials — adjust if different
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';        // default for XAMPP
$DB_NAME = 'foodapp';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_errno) {
  http_response_code(500);
  echo json_encode(['ok'=>false,'msg'=>'DB connect error']);
  exit;
}

// Use prepared statements, check if row exists and update or insert
$sql = "SELECT id FROM user_addresses WHERE user_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->store_result();

$success = false;
if ($stmt->num_rows > 0) {
  $stmt->close();
  $sql2 = "UPDATE user_addresses SET address = ?, latitude = ?, longitude = ? WHERE user_id = ?";
  $upd = $conn->prepare($sql2);
  $upd->bind_param('sssi', $address, $lat, $lon, $user_id);
  $success = $upd->execute();
  $upd->close();
} else {
  $stmt->close();
  $sql2 = "INSERT INTO user_addresses (user_id, address, latitude, longitude) VALUES (?, ?, ?, ?)";
  $ins = $conn->prepare($sql2);
  $ins->bind_param('isss', $user_id, $address, $lat, $lon);
  $success = $ins->execute();
  $ins->close();
}

$conn->close();

if ($success) {
  echo json_encode(['ok'=>true,'msg'=>'Address saved']);
} else {
  http_response_code(500);
  echo json_encode(['ok'=>false,'msg'=>'DB error while saving']);
}
