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

    exit();
}
session_destroy();

?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/join.css">
    <script src="https://static.searchai.me/jeonnam/zxing.min.js"></script>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-title" content="전남고 LMS" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0">
    <meta name="description" content="전남고 LMS" />
    <meta name="theme-color" content="#D3E1F8" />
    <link rel="manifest" href="/manifest.json" />
    <title>전남고 - LMS</title>

</head>

<body>
    <div class="header">
        <h1>등록</h1>
    </div>
    <div class="logo">

        <div id="question-1" class="question">
            <h2>이름이 무엇인가요?</h2>
            <input type="text" class="name" name="name" maxlength='5'>
            <button class="blue-button1" onclick="handleNext(1)">다음</button> <!-- onclick 속성 변경 -->
        </div>

        <div id="question-2" class="question">
            <h2>학년, 반, 번호를<br>입력해주세요.</h2>
            <label>학년:</label>
            <input type="number" class="number" name="grade" min="1" max="3"><br>
            <label>반:</label>
            <input type="number" class="number" name="classNumber" min="1" max="10"><br>
            <label>번호:</label>
            <input type="number" class="number" name="studentNumber" min="1" max="30"><br>
            <button class="blue-button1" onclick="handleNext(2)">다음</button> <!-- onclick 속성 변경 -->
        </div>

        <div id="question-3" class="question">
            <h2>로그인에 사용할 6자리<br>숫자 비밀번호를 설정해 주세요.</h2>
            <input type="number" class="name" name="password" oninput='handleOnInput(this, 6)'>
            <button class="blue-button1" onclick="handleNext(3)">다음</button> <!-- onclick 속성 변경 -->
        </div>

        <div id="question-4" class="question">
            <h2 style="margin-bottom: 0px;">학생증 뒷면의<br>바코드를 스캔합니다.</h2>
            <div class="alrml">사용할 카메라를 선택 후, <u>최대한 밝고</u> 가까이에서 초점을 잘 잡을 상태로 기다려주세요. 특히, 바코드에 빛이 반사되지 않도록 해주세요.</div>

            <select id="cameraList"></select>
            <button id="startButton">스캔 시작</button>
            <video id="video" width="90%" height="80px"></video>
            <p id="result"></p>
            <h2 style="margin-bottom: 0px;">바코드 인식에 어려움이 <br>있으신가요?</h2>
            <div class="alrml">바코드 아래의 9자리 번호를 입력해주세요.</div>
            <input type="number" class="name" name="barcode" oninput='handleOnInput(this, 9)'>
            <button class="blue-button" id="submit-barcode">다음</button>
        </div>

    </div>

    <form id="barcode-form" action="finish.php" method="post" style="display: none;">
        <input type="text" name="name">
        <input type="number" name="grade">
        <input type="password"  name="password">
        <input type="number" name="classNumber">
        <input type="number" name="studentNumber">
        <input type="text" name="barcode">
    </form>


    <div class="footer-container">
        <span>Jeonnam High School Conucil © 2024</span>
    </div>
    <script src="/assets/js/join.js"></script>
</body>

</html>