<?php
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    if(strpos($user_agent, 'NAVER') !== false || strpos($user_agent, 'KAKAOTALK') !== false) {
        header('Location: /browser.html');
        exit();
    }


require_once('../lib/db_connection.php'); //DB Connenction Account

$name = $_POST['name'];
$grade = $_POST['grade'];
$classNumber = $_POST['classNumber'];
$studentNumber = $_POST['studentNumber'];
$password = $_POST['password'];
$barcode = $_POST['barcode'];



if (!isset($name) || !isset($grade) || !isset($classNumber) || !isset($studentNumber) || !isset($password) || !isset($barcode)) {
    echo '<!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>비정상 접근</title>
    </head>
    <body>
        <script>
            alert("정상적인 접근이 아닙니다.\n(비정상 접근)");
            window.location.href = "/";
        </script>
    </body>
    </html>';
    exit();
}

$name = mysqli_real_escape_string($conn, $name); //이름
$grade = mysqli_real_escape_string($conn, $grade);  //학년
$class = mysqli_real_escape_string($conn, $classNumber); //반
$number = mysqli_real_escape_string($conn, $studentNumber);   // 번호
$barcode = mysqli_real_escape_string($conn, $barcode);  // 바코드
$password = mysqli_real_escape_string($conn, $password);   // 비밀번호



// 중복 유저 확인
$checkStmt = $conn->prepare("SELECT * FROM Students WHERE grade = ? AND class = ? AND number = ?");
$checkStmt->bind_param("iii", $grade, $class, $number);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    echo '<!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SQL 준비 실패</title>
    </head>
    <body>
        <script>
            alert("이미 가입 된 사용자 입니다.\n 로그인을 해주십시오.");
            window.location.href = "/login.php";
        </script>
    </body>
    </html>';
    exit();
} else {
    // 비밀번호 해시 처리
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO Students (name, grade, class, number, barcode, password) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo '<!DOCTYPE html>
        <html lang="ko">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>오류</title>
        </head>
        <body>
            <script>
                alert("SQL 바인딩 실패\n 학생회로 문의해주십시오.");
                window.location.href = "/";
            </script>
        </body>
        </html>';
        exit();
    }
    $bind = $stmt->bind_param("siiiss", $name, $grade, $class, $number, $barcode, $hashed_password);
    if ($bind === false) {
        echo '<!DOCTYPE html>
        <html lang="ko">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>바인딩 실패</title>
        </head>
        <body>
            <script>
                alert("바인딩 실패\n(서버 오류가 발생하였으니 학생회로 문의 해주십시오.)");
                window.location.href = "/";
            </script>
        </body>
        </html>';
        exit();
    }

    // Execute
    $exec = $stmt->execute();
    if ($exec === false) {
        echo '<!DOCTYPE html>
        <html lang="ko">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>등록 실패</title>
        </head>
        <body>
            <script>
                alert("등록에 실패하였습니다. \n다시시도해주시거나 학생회로 문의해주시기 바랍니다.");
                window.location.href = "/";
            </script>
        </body>
        </html>';
        exit();
    } else {

        // Start session and set session variables
        session_start();
        $_SESSION["name"] = $name;
        $_SESSION["grade"] = $grade;
        $_SESSION["class"] = $classNumber;
        $_SESSION["number"] = $studentNumber;
        $_SESSION["barcode"] = $barcode;

    }
}

$checkStmt->close();
$stmt->close();
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
    <link rel="stylesheet" href="/assets/css/main.css">
    <title>전남고 - LMS</title>
</head>

<body>
    <div class="header margin">
        <h1>완료!</h1>
    </div>

    <div class="logo">
        <div class="sub-title hidden" id="name">이름 등록 중..</div>
        <div class="sub-title hidden" id="grade">학년, 반, 번호 등록 중..</div>
        <div class="sub-title hidden" id="barcode">학생증 등록 중..</div>
        <div class="sub-title hidden" id="encryption">암호화 중..</div>
        <div class="sub-title hidden" id="finish">완료되었습니다!</div>
    </div>

    <div class="go-start">
        <button class="blue-button hidden" id="start-button" onclick="location.href='/dashboard.php' ">시작하기</button>
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
            }, 1000);
            setTimeout(function() {
                let barcode = document.getElementById('barcode');
                barcode.classList.remove('hidden');
                barcode.style.animation = 'fade-in-up 1s';
            }, 2000);
            setTimeout(function() {
                let encryption = document.getElementById('encryption');
                encryption.classList.remove('hidden');
                encryption.style.animation = 'fade-in-up 1s';
            }, 3000);
            setTimeout(function() {
                let finish = document.getElementById('finish');
                finish.classList.remove('hidden');
                finish.style.animation = 'fade-in-up 1s';
            }, 4300);
            setTimeout(function() {
                let startbutton = document.getElementById('start-button');
                startbutton.classList.remove('hidden');
                startbutton.style.animation = 'fade-in-up 1s';
            }, 5000);
        }
    </script>
</body>

</html>