<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>師資</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>

    <style>
        .hero {
            background-image: url('../img/bg_table.jpg');
        }
    </style>

</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid px-0 d-flex align-items-center">
                <a class="navbar-brand ms-3" href="../index.html" style="height: 40px;">
                    <img src="../img/hogwarts_LOGO.png" alt="Hogwarts Logo" style="height: 100%;">
                </a>
                <ul class="navbar-nav mx-auto d-flex flex-row" style="list-style: none;">
                    <li class="nav-item">
                        <a class="nav-link" href="../10_houses/houses.html">學院</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../20_professor/professor.php">師資</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../30_courses/courses.html">課程</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../40_activities/activities.html">活動</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../50_alumni/alumni.html">交通</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../60_test/test.html">分院測驗</a>
                    </li>
                </ul>
                <a class="btn btn-outline-light mx-4" href="../login/login.html">登入</a>

            </div>
        </nav>
    </header>

    <main>

        <!-- Hero 區 -->
        <section class="hero d-flex justify-content-center align-items-center text-center text-light">
            <div class="fog"></div>
            <div class="hero-text">
                <h1 class="fw-bold text-warning py-2">師資介紹</h1>
                <p>經驗豐富的魔法導師團隊，帶領你踏入魔法世界的第一步。</p>
            </div>
        </section>
        <div class="magic-divider"></div>

        <!-- 主體 -->
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="搜尋教授..." aria-label="搜尋課程"
                            aria-describedby="button-search">
                        <button class="btn btn-outline-secondary" type="button" id="button-search">搜尋</button>
                    </div>
                </div>
            </div>
        </div>

        <br><br><br>
        <div class="d-flex gap-5 flex-wrap justify-content-center custom-padding">
            <?php
            $conn = new mysqli('localhost', 'root', '', 'hogwarts');
            if ($conn->connect_error) {
                die("連線錯誤: " . $conn->connect_error);
            }
            $sql = "SELECT pname, title, pphoto FROM professor";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                $img = !empty($row['pphoto']) ? "../professor_photos/" . htmlspecialchars($row['pphoto']) : "../img/default.jpg";
                echo '
                <div class="card img-fluid hvr-grow" style="width:250px">
                    <img class="card-img-top" src="' . $img . '" alt="教授照片">
                    <div class="card-body text-center">
                        <h4 class="card-title text-warning">' . htmlspecialchars($row['pname']) . '</h4>
                        <h5 class="card-text text-white">' . htmlspecialchars($row['title']) . '</h5>
                    </div>
                </div>';
            }
            $conn->close();
            ?>
        </div>

    </main>

    <br><br><br>

    <a href="#" class="back-to-top" data-aos="fade-up">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
            class="bi bi-arrow-up-circle text-white text-opacity-75" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707z" />
        </svg>
    </a>

    <footer class="text-center text-light py-4">
        <p>© 2025 霍格華茲魔法學校. All rights reserved.</p>
        <p class="fst-italic">「別忘了檢查你的貓頭鷹郵件信箱！」</p>
    </footer>

    <!-- 背景星星動畫 -->
    <div id="particles-js"></div>
    <script>
        tsParticles.load("particles-js", {
            background: {
                color: "#10141b"  // 背景深藍色
            },
            particles: {
                number: { value: 50 },
                color: { value: "#d2aa6b" }, // 金色
                shape: { type: "star" },
                opacity: { value: 0.8 },
                size: { value: 2 },
                move: {
                    enable: true,
                    speed: 0.3, // 緩慢移動
                    direction: "none",
                    random: true,
                    straight: false
                }
            },
            fullScreen: {
                enable: true,
                zIndex: -1 // 讓粒子在最底層
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>