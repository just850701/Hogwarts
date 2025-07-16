<?php
include 'db.php';

$id = $_GET['id'];

$sql = "DELETE FROM teachers WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "錯誤: " . $conn->error;
}

$conn->close();
?>
