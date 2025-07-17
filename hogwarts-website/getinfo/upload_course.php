<?php
// 資料庫連線
$conn = new mysqli("localhost", "root", "", "hogwarts");
$conn->set_charset("utf8");

// 確保表單送出
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cname = $_POST['cname'];
    $description = $_POST['description'];

    // 確保圖片有上傳成功
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = "../img/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_path = $upload_dir . $image_name;

        // 移動檔案到指定資料夾
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
            // 儲存資料到資料庫
            $stmt = $conn->prepare("INSERT INTO courses (cname, description, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $cname, $description, $image_name);
            $stmt->execute();

            echo "<p style='color:lightgreen;'>課程新增成功！</p>";
            echo "<a href='../30_courses/courses.html'>返回課程頁面</a>";
        } else {
            echo "<p style='color:red;'>圖片上傳失敗！</p>";
        }
    } else {
        echo "<p style='color:red;'>請選擇圖片檔案！</p>";
    }
}
?>
