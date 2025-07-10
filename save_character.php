<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// ข้อมูลการเชื่อมต่อ
$host = "localhost";
$user = "root";
$password = "";
$db = "vian_tian";

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "เชื่อมต่อไม่สำเร็จ"]));
}

// รับข้อมูล JSON จาก JavaScript
$data = json_decode(file_get_contents("php://input"), true);
$character = $data['character'];
$name = $data['name'];

// บันทึกลงฐานข้อมูล
$stmt = $conn->prepare("INSERT INTO characters (character_name, user_name) VALUES (?, ?)");
$stmt->bind_param("ss", $character, $name);
$stmt->execute();

// ส่งสถานะกลับ
echo json_encode(["status" => "success", "message" => "บันทึกสำเร็จ"]);
$conn->close();
?>

