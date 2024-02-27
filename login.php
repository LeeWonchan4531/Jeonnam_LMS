<?php
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    if(strpos($user_agent, 'NAVER') !== false || strpos($user_agent, 'KAKAOTALK') !== false) {
        header('Location: /browser.html');
        exit();
    }

session_start();


if (isset($_SESSION["name"]) and isset($_SESSION["grade"]) and isset($_SESSION["class"]) and isset($_SESSION["number"]) and isset($_SESSION["barcode"])) {
    // 로그인 되어있는 상태일경우
    header('Location: dashboard.php');
    // Destroy the session data

    exit();
}
session_destroy();

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
    <link rel="stylesheet" href="/assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>전남고 - LMS</title>
</head>

<body>

    <div class="content">
        <img src="/assets/img/logo.png">
        <div class="text">전남고 LMS에 오신것을 환영합니다.</div>
        <form action="login.logic.php" method="POST">
            <div class="field-group">
                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="number" required min="1" max="3" name="grade" placeholder="학년">
                </div>
                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="number" required min="1" max="10" name="class" placeholder="반">
                </div>
                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="number" required min="1" max="30" name="number" placeholder="번호">
                </div>
            </div>
            <div class="field">
                <span class="fa fa-lock"></span>
                <input type="password" name="password" placeholder="비밀번호">
            </div>

            <button>Log in</button>

            <div class="or">계정이 없나요? <a href="/">가입하기</a></div>
    </div>

    <div class="footer-container">
        <span>Jeonnam High School Conucil © 2024</span>
    </div>

    <script>
        function handleOnInput(el, maxlength) {
            if (el.value.length > maxlength) {
                el.value
                    = el.value.substr(0, maxlength);
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