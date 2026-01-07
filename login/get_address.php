<?php
// get_address.php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['ok'=>false,'msg'=>'Not authenticated']);
  exit;
}
$user_id = intval($_SESSION['user_id']);

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'foodapp';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_errno) {
  http_response_code(500);
  echo json_encode(['ok'=>false,'msg'=>'DB connect error']);
  exit;
}

$sql = "SELECT address, latitude, longitude, updated_at FROM user_addresses WHERE user_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($address, $lat, $lon, $updated_at);

if ($stmt->fetch()) {
  echo json_encode(['ok'=>true, 'address'=>$address, 'lat'=>$lat, 'lon'=>$lon, 'updated_at'=>$updated_at]);
} else {
  echo json_encode(['ok'=>false, 'msg'=>'No address']);
}
$stmt->close();
$conn->close();
