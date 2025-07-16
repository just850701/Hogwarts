<?php
// 資料庫連線（請依實際帳號密碼與資料庫名稱修改）
$conn = new mysqli('localhost', 'root', '', 'hogwarts');
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 處理上傳
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo']) && isset($_POST['professor_id'])) {
    $professor_id = intval($_POST['professor_id']); // 對應 pid
    $file = $_FILES['photo'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        // 取得副檔名並轉小寫
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // 確保副檔名存在且合理（只允許圖片）
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!$ext || !in_array($ext, $allowed_ext)) {
            echo "<script>alert('只允許上傳 jpg/jpeg/png/gif/webp 格式的圖片'); history.back();</script>";
            exit;
        }

        // 組合新檔名
        $filename = 'prof_' . $professor_id . '_' . time() . '.' . $ext;

        $folder = __DIR__ . '/professor_photos/';
        $target = $folder . $filename;

        // 若資料夾不存在，先建立
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // 移動上傳檔案
        if (move_uploaded_file($file['tmp_name'], $target)) {
            // 更新資料表的 pphoto 欄位
            $stmt = $conn->prepare("UPDATE professor SET pphoto=? WHERE pid=?");
            if ($stmt) {
                $stmt->bind_param("si", $filename, $professor_id);
                if ($stmt->execute()) {
                    echo "<script>alert('上傳成功！'); location.href='upload_professor_photo.html';</script>";
                } else {
                    echo "<script>alert('資料庫更新失敗'); history.back();</script>";
                }
                $stmt->close();
            } else {
                echo "<script>alert('預備 SQL 發生錯誤'); history.back();</script>";
            }
        } else {
            echo "<script>alert('檔案儲存失敗'); history.back();</script>";
        }
    } else {
        echo "<script>alert('檔案上傳錯誤'); history.back();</script>";
    }
} else {
    echo "<script>alert('請選擇檔案與教授'); history.back();</script>";
}

$conn->close();
?>
