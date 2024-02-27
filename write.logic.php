<?php
// Start session
session_start();
$name = $_SESSION["name"];
$grade = $_SESSION["grade"];
$class = $_SESSION["class"];
$number = $_SESSION["number"];
$barcode = $_SESSION["barcode"];
// POST 방식으로 받아온 데이터
$title = $_POST['title'];
$content = $_POST['content'];
$image = $_FILES['image'];


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






















//파일이 업로드되었는지 확인
if ($image['error'] === UPLOAD_ERR_NO_FILE) {
    $filename = '#';
} else {
    // 업로드 에러 검증
    if ($image['error'] !== UPLOAD_ERR_OK) {
        die('<!DOCTYPE html>
        <html lang="ko">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>오류</title>
        </head>
        <body>
            <script>
                alert("이미지 업로드에 실패했어요.");
                window.history.back();
            </script>
        </body>
        </html>');
    }

    // 파일 크기 검증, 예를 들어 5MB 이하만 허용
    if ($image['size'] > 5000000) {
        die('<!DOCTYPE html>
        <html lang="ko">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>오류</title>
        </head>
        <body>
            <script>
                alert("이미지 크기가 너무 커요!");
                window.history.back();
            </script>
        </body>
        </html>');
    }

    // 이미지의 형식을 검증합니다.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($image['tmp_name']),
        array(
            'jpg' => 'image/jpg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        die('<!DOCTYPE html>
        <html lang="ko">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>오류</title>
        </head>
        <body>
            <script>
                alert("지원하지 않는 이미지 형식이예요. \n 제공해주신 이미지 형식도 지원해보도록 할게요!");
                window.history.back();
            </script>
        </body>
        </html>');
    }

    // 새 파일 이름 생성
    $newName = sha1_file($image['tmp_name']);
    $filePath = sprintf('/var/www/html/staticsearchaime/2TB/timecapsule/%s.%s', $newName, $ext);

    // 파일이 이미 존재하는지 확인 후 덮어쓰기
    if (file_exists($filePath)) {
        unlink($filePath); // 기존 파일 삭제
    }

    if (!move_uploaded_file($image['tmp_name'], $filePath)) {
        die('<!DOCTYPE html>
        <html lang="ko">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>오류</title>
        </head>
        <body>
            <script>
                alert("이미지 처리 과정에 문제가 발생했어요.\n 다시 시도해주세요.");
                window.history.back();
            </script>
        </body>
        </html>');
    }

    $filename = $newName . '.' . $ext;
}








































require_once('./lib/db_connection.php'); //DB Connenction Account


// Prepared Statement 생성
$stmt = $conn->prepare("INSERT INTO community (grade, class, number, name, title, content, image_filename) VALUES (?, ?, ?, ?, ?, ?, ?)");

// 파라미터 바인딩
$stmt->bind_param("iiissss", $grade, $class, $number, $name, $title, $content, $filename);

// 쿼리 실행
if ($stmt->execute()) {
    echo '<!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>작성 성공</title>
    </head>
    <body>
        <script>
            alert("글을 작성하였습니다.");
            window.location.href = "/community.php";
        </script>
    </body>
    </html>';
    exit();
} else {
    echo '<!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>작성 실패</title>
    </head>
    <body>
        <script>
            alert("서버 오류가 발생하였습니다.\n 학생회에 문의 해주십시오.");
            window.location.href = "/community.php";
        </script>
    </body>
    </html>';
    exit();
}

// 객체 종료
$stmt->close();

// DB 연결 종료
$conn->close();
