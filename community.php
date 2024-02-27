<?php
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    if(strpos($user_agent, 'NAVER') !== false || strpos($user_agent, 'KAKAOTALK') !== false) {
        header('Location: /browser.html');
        exit();
    }

// Start session
session_start();
$name = $_SESSION["name"];
$grade = $_SESSION["grade"];
$class = $_SESSION["class"];
$number = $_SESSION["number"];
$barcode = $_SESSION["barcode"];

if (!isset($name) and !isset($grade) and !isset($class) and !isset($number) and !isset($barcode)) {
    // 로그인 하지 않고 접속했을경우
    echo '<!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>잘못된 접근</title>
    </head>
    <body>
        <script>
            alert("로그인 후 접속해주세요!");
            window.location.href = "/login.php";
        </script>
    </body>
    </html>';
    // Destroy the session data
    session_destroy();
    exit();
}
require_once('./lib/d.day.php'); //디데이
require_once('./lib/wise.php'); //명언
require_once('./lib/db_connection.php'); //DB Connenction Account


if ($grade == "1") { //1학년
    $CSAT = $CSAT2027;
    $year = "2027"; //학년도
}

if ($grade == "2") { //2학년
    $CSAT = $CSAT2026;
    $year = "2026"; //학년도
}

if ($grade == "3") { //3학년
    $CSAT = $CSAT2025;
    $year = "2025"; //학년도
}


?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-title" content="전남고 LMS" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0">
    <meta name="description" content="전남고 LMS" />
    <meta name="theme-color" content="#D3E1F8" />
    <link rel="manifest" href="/manifest.json" />
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <title>전남고 - LMS</title>
</head>

<body>
    <header>
        <h2><?php echo $name; ?>님 환영합니다.</h2>
        <span><?php echo $random_quote; //명언 ?></span>
    </header>

    <div class="d-day">

        <div class="card margin-card-left" style="width: 40%;border-radius: 20px;">
            <p>지필평가</p>
            <h1>D-<?php echo dday($semester); ?></h1>
        </div>
        <div class="card margin-card-right" style="width: 40%;border-radius: 20px;">
            <p class="text-right"><?php echo $year; ?>학년도 수능</p>
            <h1 class="text-right">D-<?php echo dday($CSAT); ?></h1>
        </div>

    </div>
    <div class="food-card">
        <div class="header">
            <h1 class="food-card-title">게시판</h1>
            <button class="blue-button" onclick="location.href='/write.php' ">작성하기</button>
        </div>
        <div class="card text-left">
            <table>
                <th>제목</th>
                <th class="view">날짜</th>
                <?php

                // SQL 쿼리
                $sql = "SELECT id, title, reg_date FROM community ORDER BY reg_date DESC";
                $result = $conn->query($sql);

                // 결과 확인 및 출력
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='padding-left: 10px;'><a href='view.php?id=" . $row['id'] . "' class='link'>" . $row['title'] . "</a></td>";
                        echo "<td>" . date('y.m.d', strtotime($row['reg_date'])) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "등록된 글이 없습니다.";
                }

                // DB 연결 종료
                $conn->close();
                ?>
            </table>
        </div>
    </div>
    <footer>
        Jeonnam High School Conucil © 2024
    </footer>

    <div class="footer-container">
        <div class="menu-container">
            <a href="https://www.instagram.com/jeonnam_hs?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="menu-item-left" target="_blank">건의함</a>
            <a href="/" class="menu-item-left">&nbsp;&nbsp;&nbsp;&nbsp;홈</a>
            <div class="logo-container">
                <img src="/assets/img/logo.png" alt="Logo" class="logo" id="rollUp" />
            </div>
            <a href="/logout.php" class="menu-item-right">로그아웃</a>
            <a href="https://jeonnam.school/" class="menu-item-right" target="_blank">학생회</a>
        </div>
    </div>


    <script>
        let rollUpBtn = document.querySelector('#rollUp');

        const scroll = () => {
            if (window.scrollY !== 0) {
                setTimeout(() => {
                    window.scrollTo(0, window.scrollY - 50);
                    scroll();
                }, 10);
            }
        }
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", () => {
                navigator.serviceWorker.register("/service-worker.js");
            });
        }
    </script>
</body>

</html>