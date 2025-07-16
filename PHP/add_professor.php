<?php
include 'db.php';

$name = $_POST['name'];
$subject = $_POST['subject'];
$bio = $_POST['bio'];

$sql = "INSERT INTO teachers (name, subject, bio) VALUES ('$name', '$subject', '$bio')";

if ($conn->query($sql) === TRUE) {
    echo "新增成功";
} else {
    echo "錯誤: " . $conn->error;
}

$conn->close();
?>
