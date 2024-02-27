<?php
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    if(strpos($user_agent, 'NAVER') !== false || strpos($user_agent, 'KAKAOTALK') !== false) {
        header('Location: /browser.html');
        exit();
    }


session_start();


if (isset($_SESSION["name"]) and isset($_SESSION["grade"]) and isset($_SESSION["class"]) and isset($_SESSION["number"]) and isset($_SESSION["barcode"])) {
    // 로그인 되어있는 상태일경우
    header('Location: /dashboard.php');
    // Destroy the session data

    exit();
}
session_destroy();

require_once('./lib/agent.php'); //에이전트 분석

/* iOS, Android 여부에 따라 다른 코드를 실행합니다. */
if (is_ios()) {
	// iOS 환경에서 사용할 코드
    require_once('iphone.php');
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
        <button class="blue-button" id="start-button" onclick="startFade()">시작하기</button>

    </div>
    <div class="login" id="login-section">이미 계정이 있으신가요?&nbsp;<a href="login.php">로그인 하기!</a></div>
    <div class="footer-container">
        <span>Jeonnam High School Conucil © 2024</span>
    </div>
    <script>
        let deferredPrompt;

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            // 설치를 제안하는 팝업이 떴다는 것은 PWA가 아직 설치되지 않았다는 뜻이므로, 버튼 텍스트를 '설치하기'로 변경합니다.
            document.getElementById('start-button').innerText = '앱을 설치하여 시작하기';
            document.getElementById('login-section').style.display = 'none';
        });

        window.addEventListener('appinstalled', () => {
            // PWA가 설치되었다는 것을 감지하여 버튼 텍스트를 '시작하기'로 변경합니다.
            document.getElementById('start-button').innerText = '시작하기';
            document.getElementById('login-section').style.display = 'block';
        });

        function startFade() {
            // 앱이 설치되었는지 확인
            if (document.getElementById('start-button').innerText === '시작하기') {
                location.href = '/start/';
            } else {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the A2HS prompt');
                        location.href = '/congratulation.php';
                    } else {
                        console.log('User dismissed the A2HS prompt');
                    }
                    deferredPrompt = null;
                });
            }

            // 앱이 설치되지 않았을 때만 애니메이션 적용
            if (document.getElementById('start-button').innerText !== '앱을 설치하여 시작하기') {
                document.body.classList.add('fade-out');
                setTimeout(function() {
                    location.href = '/start/';
                }, 1000);
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