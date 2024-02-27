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
        <h1 class="food-card-title">작성✏️</h1>
        <div class="card text-left">
            <form action="write.logic.php" method="POST" onsubmit="return confirmChanges();" enctype="multipart/form-data">
                <h2 class="article-title">제목</h2>
                <input type="text" class="name" placeholder="제목을 입력해주세요." name="title" required>
                <h2 class="article-title">내용</h2>
                <textarea placeholder="내용을 입력해주세요" onkeydown="resize(this)" required name="content"
                    onkeyup="resize(this)"></textarea>
                <h2 class="article-title">이미지 첨부</h2>
                <input type="file" name="image" accept="image/*">
                <div class="text-center">
                    <button class="write-button" type="submit">작성하기</button>
                </div>
            </form>
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
                <img src="/assets/img/logo.png" alt="Logo" class="logo" />
            </div>
            <a href="/logout.php" class="menu-item-right">로그아웃</a>
            <a href="https://jeonnam.school/" class="menu-item-right" target="_blank">학생회</a>
        </div>
    </div>


    <script>

        if ("serviceWorker" in navigator) {
            window.addEventListener("load", () => {
                navigator.serviceWorker.register("/service-worker.js");
            });
        }



        function resize(obj) {
            obj.style.height = '1px';
            obj.style.height = (obj.scrollHeight) + 'px';
        }

        function confirmChanges() {
            var name = document.querySelector('input[name="title"]').value;
            var article = document.querySelector('textarea[name="content"]').value;
            var image = document.querySelector('input[name="image"]').value.split('\\').pop();

            // 내용입력이 900자를 초과하는지 검사
            if (article.length > 900) {
                alert("내용은 900자까지만 담을 수 있어요.\n조금만 더 요약하여 작성해주세요.");
                return false;
            }

            var confirmMessage = "수정, 삭제가 어려우니, 다시한번 확인해주세요.\n" +
                "이름: " + name + "\n" +
                "내용: " + article;

            // 이미지가 있을 경우만 confirmMessage에 추가
            if (image) {
                confirmMessage += "\n이미지: " + image;
            }

            return confirm(confirmMessage);
        }
    </script>
</body>

</html>