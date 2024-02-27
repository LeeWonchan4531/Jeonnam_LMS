<?php 
require_once('./lib/db_connection.php'); //DB Connenction Account


$grade = mysqli_real_escape_string($conn, $_POST['grade']);
$class = mysqli_real_escape_string($conn, $_POST['class']);
$number = mysqli_real_escape_string($conn, $_POST['number']);
$password = mysqli_real_escape_string($conn, $_POST['password']); 

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM Students WHERE grade = ? AND class = ? AND number = ?");
$stmt->bind_param("iii", $grade, $class, $number);

// Execute and get result
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Check password
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {

        // Start session and set session variables
        session_start();
        $_SESSION["name"] = $row['name'];
        $_SESSION["grade"] = $row['grade'];
        $_SESSION["class"] = $row['class'];
        $_SESSION["number"] = $row['number'];
        $_SESSION["barcode"] = $row['barcode'];

        header( 'Location: dashboard.php' );
    } else {
        // Password is incorrect
    echo '<!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>에러발생</title>
    </head>
    <body>
        <script>
            alert("학년, 반, 번호, 비밀번호가 다릅니다. \n입력하신 정보를 다시 확인해주세요.");
            window.location.href = "login.php";
        </script>
    </body>
    </html>';
    }
} else {
        // 유저가 없을경우
        echo '<!DOCTYPE html>
        <html lang="ko">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>에러발생</title>
        </head>
        <body>
            <script>
                alert("학년, 반, 번호, 비밀번호가 다릅니다. \n입력하신 정보를 다시 확인해주세요.");
                window.location.href = "login.php";
            </script>
        </body>
        </html>';
}

$stmt->close();
$conn->close();