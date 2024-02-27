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
// GET 방식으로 받아온 글 id 값
$id = $_GET['id'];


if (!isset($_GET['id'])) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

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



// SQL 쿼리
$sql = "SELECT title, content, image_filename FROM community WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// 결과 출력
if ($row) {
    $title = $row['title'];
    $content = $row['content'];
    if ($row['image_filename'] != "#") {
        $image =  "<img src='https://img.jeonnam.school/" . $row['image_filename'] . "' alt='Image' width='100%'>";
    }
} else {
    header("HTTP/1.0 404 Not Found");
    exit();
}

// 객체 종료
$stmt->close();

// DB 연결 종료
$conn->close();

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
        <span><?php echo $random_quote; //명언 
                ?></span>
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
            <h1 class="food-card-title">게시글</h1>
            <button class="blue-button" style="padding-right: 10px; padding-left: 10px;" onclick="location.href='/community.php' ">글 목록</button>
        </div>
        <div class="card text-left">
            <h2 class="article-title" style="border-bottom: 1px solid black;margin-bottom: 10px;">제목: <?php echo $title; ?></h2>

            <p><?php
                if (isset($image)) {
                    echo $image;
                }


                echo $content ?></p>
            <div class="text-center" style="margin-top: 50px;">
                <div id="disqus_thread"></div>
                <script>
                    /**
                     *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                     *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
                    /*
                    var disqus_config = function () {
                    this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                    this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                    };
                    */
                    (function() { // DON'T EDIT BELOW THIS LINE
                        var d = document,
                            s = d.createElement('script');
                        s.src = 'https://jeonnam.disqus.com/embed.js';
                        s.setAttribute('data-timestamp', +new Date());
                        (d.head || d.body).appendChild(s);
                    })();
                </script>
                <noscript>댓글 기능을 이용하시려면 자바스크립트 기능을 허용하십시오.</noscript>
            </div>
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
    </script>
</body>

</html>