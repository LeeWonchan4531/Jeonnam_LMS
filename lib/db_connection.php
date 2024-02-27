<?php
    $servername = "localhost";
    $username = "#";
    $password = "#";
    $dbname = "#";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("DB서버 연결실패. 심각한 오류가 발생했으니 얼른 학생회에 연락주세요!");
    }