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
require_once('./lib/neis.php'); //나이스 API

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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
    <div class="student-crad">
        <div class="id-card text-center">
            <h1>학생증</h1>
            <img src="/lib/barcode.php" width="90%">
            <p class="barcode-var"><?php echo $barcode; ?></p>
            <p class="student-info">
                <img src="/assets/img/logo.png" width="50px">
                <?php echo $grade; ?>학년 <?php echo $class; ?>반 <?php echo $number; ?>번 <?php echo $name; ?>
            </p>
        </div>
    </div>
    <div class="food-card">
        <h1 class="food-card-title">오늘의 메뉴</h1>
        <div class="card text-left">
            <div class="food-title">중식🍱 <span class="Kcal">(<?php lunch("CAL_INFO", $lunchurl);?>)</span></div>
            <div class="food-content">
<?php lunch("DDISH_NM", $lunchurl);?>
            </div>
        </div>
        <div class="card text-left" style="margin-top: 20px;">
            <div class="food-title">석식🍗 <span class="Kcal">(<?php dinner("CAL_INFO", $dinnerurl);?>)</span></div>
            <div class="food-content">
            <?php dinner("DDISH_NM", $dinnerurl);?>
            </div>
        </div>
    </div>
    <div class="wow-card">
        <h1 class="food-card-title">일정 🗓️</h1>
        <div class="card text-left">
<?php echo schedule($Schedule);  ?>
        </div>
    </div>

    <div class="wow-card">
        <h1 class="food-card-title">알림 🔔</h1>
        <div class="card text-left">
            <p>알림이 없습니다.</p>
        </div>
    </div>

    <footer>
        Jeonnam High School Conucil © 2024
    </footer>

    <div class="footer-container">
        <div class="menu-container">
            <a href="https://www.instagram.com/jeonnam_hs?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="menu-item-left" target="_blank">건의함</a>
            <a href="/community.php" class="menu-item-left">커뮤니티</a>
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

        rollUpBtn.addEventListener('click', scroll);
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", () => {
                navigator.serviceWorker.register("/service-worker.js");
            });
        }

        
    </script>
</body>

</html>