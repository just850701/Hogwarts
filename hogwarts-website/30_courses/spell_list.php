<?php
// 資料庫連線
$pdo = new PDO("mysql:host=localhost;dbname=hogwarts;charset=utf8", "root", "");

// 只撈出有咒語的課程
$courses = $pdo->query("
    SELECT DISTINCT c.cid, c.cname
    FROM courses c
    JOIN courses_spell cs ON c.cid = cs.cid
")->fetchAll(PDO::FETCH_ASSOC);

// 判斷目前選取的課程
$selected_cid = isset($_GET['cid']) ? $_GET['cid'] : 'all';

// 根據選取的課程查詢咒語
if ($selected_cid === 'all') {
    $stmt = $pdo->query("
        SELECT s.sid, s.sname, s.spell
        FROM spell s
        JOIN courses_spell cs ON s.sid = cs.sid
        GROUP BY s.sid
        ORDER BY s.sname
    ");
} else {
    $stmt = $pdo->prepare("
        SELECT s.sid, s.sname, s.spell
        FROM spell s
        JOIN courses_spell cs ON s.sid = cs.sid
        WHERE cs.cid = ?
        ORDER BY s.sname
    ");
    $stmt->execute([$selected_cid]);
}

$spells = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>咒語列表</title>
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <script src="../js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-0 d-flex align-items-center">
            <a class="navbar-brand ms-3" href="../index.html" style="height: 40px;">
            <img src="../img/hogwarts_LOGO.png" alt="Hogwarts Logo" style="height: 100%;">
            </a>
            <ul class="navbar-nav mx-auto d-flex flex-row" style="list-style: none;">
            <li class="nav-item"><a class="nav-link" href="../10_houses/houses.html">學院</a></li>
            <li class="nav-item"><a class="nav-link" href="../20_professor/professor.html">師資</a></li>
            <li class="nav-item"><a class="nav-link" href="../30_courses/courses.html">課程</a></li>
            <li class="nav-item"><a class="nav-link" href="../40_activities/activities.html">活動</a></li>
            <li class="nav-item"><a class="nav-link" href="../50_alumni/alumni.html">交通</a></li>
            <li class="nav-item"><a class="nav-link" href="../60_test/test.html">分院測驗</a></li>
            </ul>
            <!-- 登入區 -->
            <div id="login-area" class="mx-4 text-light"></div>
        </div>
        </nav>

    </header>
    <br><br><br>
    <h1 class="text-center mt-4 text-warning">咒語列表</h1>


    <div class="container my-4 "style="max-width: 450px;">
        <form method="get" action="spell_list.php" class="row justify-content-center">
            <div class="col-md-6">
                <label for="cid" class="form-label fw-bold text-center w-100">依課程分類：</label>
                <select name="cid" id="cid" class="form-select" onchange="this.form.submit()">
                    <option value="all" <?= $selected_cid === 'all' ? 'selected' : '' ?>>全部</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= $course['cid'] ?>" <?= $selected_cid == $course['cid'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($course['cname']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>

    <div class="magic-divider"></div>

    <?php if (count($spells) === 0): ?>
        <p>此課程尚無任何咒語。</p>
    <?php else: ?>
        <div class="container spell-list-container mt-5" style="max-width: 600px;">
            <div class="bg-dark bg-opacity-75 p-4 rounded shadow" style="color: white;">
                <ul class="list-group fs-5">
                    <?php foreach ($spells as $spell): ?>
                        <li class="list-group-item bg-transparent border-light text-white d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-warning"><?= htmlspecialchars($spell['sname']) ?></span>
                            <span class="text-light"><?= htmlspecialchars($spell['spell']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>


    <?php endif; ?>

    <br><br><br>
    <div class="magic-divider"></div>

    <footer class="text-center text-light py-4">
        <p>© 2025 霍格華茲魔法學校. All rights reserved.</p>
        <p class="fst-italic">「別忘了檢查你的貓頭鷹郵件信箱！」</p>
    </footer>

    <!-- 星星背景動畫 -->
    <div id="particles-js"></div>
    <script>
        tsParticles.load("particles-js", {
        background: { color: "#10141b" },
        particles: {
            number: { value: 50 },
            color: { value: "#d2aa6b" },
            shape: { type: "star" },
            opacity: { value: 0.8 },
            size: { value: 2 },
            move: { enable: true, speed: 0.3, direction: "none", random: true, straight: false }
        },
        fullScreen: { enable: true, zIndex: -1 }
        });

        // auth.js

        document.addEventListener("DOMContentLoaded", () => {
        const loginArea = document.getElementById("login-area");
        const professorName = localStorage.getItem("professorName");

        if (professorName) {
            // ✅ 已登入狀態，顯示名稱＋登出
            loginArea.innerHTML = `
        <span class="me-2">👨‍🏫 ${professorName}</span>
        <button id="logout-btn" class="btn btn-sm btn-outline-light">登出</button>
        `;

            document.getElementById("logout-btn").addEventListener("click", () => {
            if (confirm("確定要登出嗎？")) {
                localStorage.removeItem("professorName");
                location.reload(); // 重新整理頁面
            }
            });

        } else {
            // ❌ 未登入狀態，顯示登入按鈕
            loginArea.innerHTML = `
        <a href="../login/login.html" class="btn btn-sm btn-outline-warning">登入</a>
        `;
        }
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="./js/auth.js"></script>

</body>
</html>
