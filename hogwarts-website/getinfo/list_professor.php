<?php
$conn = new mysqli('localhost', 'root', '', 'hogwarts');
$conn->set_charset("utf8");

$result = $conn->query("SELECT pid, pname, title FROM professor");
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
