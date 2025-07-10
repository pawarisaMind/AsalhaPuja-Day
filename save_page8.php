<?php
header("Content-Type: application/json");

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "vian_tian");
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["status" => "error", "message" => "Database connection failed"]);
  exit();
}

// รับข้อมูลจาก JavaScript
$data = json_decode(file_get_contents("php://input"), true);

// ดึงค่าจากข้อมูล
$character = $data['character'] ?? '';
$name = $data['name'] ?? '';
$temple = $data['temple'] ?? '';
$offering = $data['offering'] ?? '';
$wish = $data['wish'] ?? '';

// บันทึก
$stmt = $conn->prepare("INSERT INTO page8_data (character_name, user_name, temple, offering, wish) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $character, $name, $temple, $offering, $wish);
$stmt->execute();

echo json_encode(["status" => "success", "message" => "บันทึกเรียบร้อย"]);
$conn->close();
?>
