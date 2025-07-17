<?php
// 資料庫連線
$conn = new mysqli("localhost", "root", "", "hogwarts");
$conn->set_charset("utf8");

// 查詢課程
$sql = "SELECT pid, pname, title, pphoto FROM professor";
$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// 回傳 JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
