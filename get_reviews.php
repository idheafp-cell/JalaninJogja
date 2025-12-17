<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "jalaninjogja");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

if (!isset($_GET['wisata_id']) || !is_numeric($_GET['wisata_id'])) {
    echo json_encode(["status" => "error", "message" => "wisata_id is required."]);
    exit;
}

$wisata_id = intval($_GET['wisata_id']);

$sql = "SELECT nama, review, rating FROM reviews WHERE wisata_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $wisata_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo json_encode(["status" => "error", "message" => $conn->error]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(["status" => "success", "reviews" => $data]);

$stmt->close();
$conn->close();
?>