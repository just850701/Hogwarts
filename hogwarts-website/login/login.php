<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// 確保收到 JSON
$input = json_decode(file_get_contents("php://input"), true);

if (!$input || !isset($input['pid']) || !isset($input['password'])) {
    echo json_encode(["success" => false, "message" => "⚠️ 沒收到正確的 JSON 資料"]);
    exit();
}

$pid = $input['pid'];
$password = $input['password'];

// 🔧 請確認你資料庫裡有這些帳號資料
$mysqli = new mysqli("localhost", "root", "", "hogwarts");
$mysqli->set_charset("utf8");

if ($mysqli->connect_error) {
    echo json_encode(["success" => false, "message" => "資料庫錯誤：" . $mysqli->connect_error]);
    exit();
}

$stmt = $mysqli->prepare("SELECT pname FROM professor WHERE pid = ? AND password = ?");
$stmt->bind_param("is", $pid, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();
    echo json_encode(["success" => true, "name" => $row["pname"]]);
} else {
    echo json_encode(["success" => false, "message" => "帳號或密碼錯誤"]);
}

$stmt->close();
$mysqli->close();
