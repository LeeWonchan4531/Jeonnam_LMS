<?php 
    require_once('../lib/agent.php'); //에이전트 분석
if (is_android()) {
	// android 환경에서 사용할 코드
    header( 'Location: /' );
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
    <link rel="stylesheet" href="/assets/css/main.css">
    <style>
        body {
            transition: 1s opacity;
            text-align: center;
            padding-left: 20px;
            padding-right: 20px;
        }

        .fade-out {
            opacity: 0;
        }

        h1 {
            text-align: left;
            border-bottom: 1px solid gray;
        }

    </style>
    <title>전남고 - LMS</title>
</head>

<body>
    <h1 style="border: none;">진행을 위해 앱을<br>설치해주세요.</h1>
<h1>앱 설치 방법</h1>
<img src="/assets/img/step1.jpeg" width="80%">
<p>브라우저 하단에 있는 공유 아이콘을 탭합니다.</p>
<img src="/assets/img/step2.png" width="80%">
<p>홈 화면에 추가를 탭합니다.</p>
<img src="/assets/img/step3.png" width="80%">
<p style="margin-bottom: 7vh;">우측 상단에 있는 추가를 탭합니다.</p>
<h2 style="margin-bottom: 17vh;">이제 브라우저를 종료하고<br>"전남고 LMS" 앱을 실행시켜주세요!</h2>
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