<?php
// 資料庫連線
$conn = new mysqli("localhost", "root", "", "hogwarts");
$conn->set_charset("utf8");

// 查詢教授與對應課程名稱（多對多）
$sql = "
    SELECT 
        professor.pid,
        professor.pname,
        professor.title,
        professor.pphoto,
        GROUP_CONCAT(courses.cname SEPARATOR ', ') AS course_names
    FROM 
        professor
    LEFT JOIN course_professor ON professor.pid = course_professor.pid
    LEFT JOIN courses ON course_professor.cid = courses.cid
    GROUP BY 
        professor.pid
";

$result = $conn->query($sql);

$professors = [];

while ($row = $result->fetch_assoc()) {
    $professors[] = $row;
}

// 回傳 JSON 格式資料給前端
header('Content-Type: application/json');
echo json_encode($professors);
?>
