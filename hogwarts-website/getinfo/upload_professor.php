<?php
$conn = new mysqli("localhost", "root", "", "hogwarts");
$conn->set_charset("utf8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pname = $_POST['pname'];
    $title = $_POST['title'];
    $courses = isset($_POST['courses']) ? $_POST['courses'] : [];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = "../img/";
        $image_name = time() . "_" . basename($_FILES["image"]["name"]); // 避免重名
        $target_path = $upload_dir . $image_name;

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "<p style='color:red;'>請上傳有效圖片！</p>";
            exit;
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
            // 檔案移動成功，準備寫入資料庫
            $password = "1234"; // 預設密碼
            $stmt = $conn->prepare("INSERT INTO professor (pname, title, pphoto, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $pname, $title, $image_name, $password);
            $stmt->execute();

            $pid = $stmt->insert_id;

            // 如果有選課，寫入中介表
            if (!empty($courses)) {
                $conn->query("DELETE FROM course_professor WHERE pid = $pid");

                $stmt = $conn->prepare("INSERT IGNORE INTO course_professor (cid, pid) VALUES (?, ?)");
                foreach ($courses as $cid) {
                    $stmt->bind_param("ii", $cid, $pid);
                    $stmt->execute();
                }
            }

            echo "<p style='color:lightgreen;'>教授新增成功！</p>";
            echo "<a href='../20_professor/professor.html'>返回教授頁面</a>";
        } else {
            echo "<p style='color:red;'>圖片上傳失敗！</p>";
        }
    } else {
        echo "<p style='color:red;'>請選擇圖片檔案！</p>";
    }
}
?>
