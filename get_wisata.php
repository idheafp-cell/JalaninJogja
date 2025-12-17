<?php
// Create connection
$conn = new mysqli("localhost", "root", "", "jalaninjogja");

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => $conn->connect_error]);
    exit;
}

// Query data
$sql = "SELECT id, latitude, longitude, nama_wisata, kategori, deskripsi, img FROM data_wisata";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["status" => "error", "message" => $conn->error]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(["status" => "success", "wisata" => $data]);
$conn->close();
?>