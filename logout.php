<?php
session_start(); // 세션 시작

// 로그인 상태가 아니면 메인 페이지로 리다이렉트
if(!isset($_SESSION['name']) && !isset($_SESSION['grade']) && !isset($_SESSION['class']) && !isset($_SESSION['number']) && !isset($_SESSION['barcode'])) {
    header('Location: /login.php');
    // 세션 파괴
    session_destroy();
    exit();
}

// 세션 변수 제거
if(isset($_SESSION['name'])) {
    unset($_SESSION['name']);
}

if(isset($_SESSION['id'])) {
    unset($_SESSION['id']);
}

// 세션 파괴
session_destroy();

// 로그인 페이지로 리다이렉트
header('Location: /login.php');
exit();
?>