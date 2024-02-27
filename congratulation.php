<?php 
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    if(strpos($user_agent, 'NAVER') !== false || strpos($user_agent, 'KAKAOTALK') !== false) {
        header('Location: /browser.html');
        exit();
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
    <title>전남고 - LMS</title>
</head>

<body>
    <div class="header margin">
        <h1>설치</h1>
    </div>

    <div class="logo">
        <div class="sub-title hidden" id="name">패키지 다운로드 중..</div>
        <div class="sub-title hidden" id="grade">압축 해제 중..</div>
        <div class="sub-title hidden" id="barcode">폰트 다운로드 중..</div>
        <div class="sub-title hidden" id="encryption">암호화 중..</div>
        <div class="sub-title hidden" id="finish">완료되었습니다🎉</div>
    </div>

    <div class="go-start">
        <button class="blue-button hidden" id="start-button" >설치된 앱을 실행시켜, 계속 진행해주세요.</button>
    </div>
    <div class="footer-container">
        <span>Jeonnam High School Conucil © 2024</span>
    </div>
    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", () => {
                navigator.serviceWorker.register("/service-worker.js");
            });
        }

        window.onload = function() {
            setTimeout(function() {
                let name = document.getElementById('name');
                name.classList.remove('hidden');
                name.style.animation = 'fade-in-up 1s';
            }, 100);
            setTimeout(function() {
                let grade = document.getElementById('grade');
                grade.classList.remove('hidden');
                grade.style.animation = 'fade-in-up 1s';
            }, 5000);
            setTimeout(function() {
                let barcode = document.getElementById('barcode');
                barcode.classList.remove('hidden');
                barcode.style.animation = 'fade-in-up 1s';
            }, 7000);
            setTimeout(function() {
                let encryption = document.getElementById('encryption');
                encryption.classList.remove('hidden');
                encryption.style.animation = 'fade-in-up 1s';
            }, 11000);
            setTimeout(function() {
                let finish = document.getElementById('finish');
                finish.classList.remove('hidden');
                finish.style.animation = 'fade-in-up 1s';
            }, 14500);
            setTimeout(function() {
                let startbutton = document.getElementById('start-button');
                startbutton.classList.remove('hidden');
                startbutton.style.animation = 'fade-in-up 1s';
            }, 15000);
        }
    </script>
</body>

</html>