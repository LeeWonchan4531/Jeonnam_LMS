
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
    <link rel="stylesheet" href="/assets/css/main.css">
    <style>
        body {
            transition: 1s opacity;
        }

        .fade-out {
            opacity: 0;
        }
    </style>
    <title>전남고 - LMS</title>
</head>

<body>
    <div class="logo">
        <img src="/assets/img/logo.png" width="40%">
        <div class="sub-title">여러분의 동반자가 될 전남고<br>LMS에 오신 것을 환영합니다.</div>
    </div>

    <div class="go-start">
        <button class="blue-button" id="start-button" onclick="location.href='/iphone/'">시작하기</button>

    </div>
    <div class="login" id="login-section">이미 계정이 있으신가요?&nbsp;<a href="login.php">로그인 하기!</a></div>
    <div class="footer-container">
        <span>Jeonnam High School Conucil © 2024</span>
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