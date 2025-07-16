<?php
$servername = "localhost";
$username = "root";
$password = ""; // XAMPP 預設
$dbname = "hogwarts"; // 你在 phpMyAdmin 建的資料庫名稱

$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}
?>
