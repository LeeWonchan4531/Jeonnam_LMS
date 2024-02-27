<?php
date_default_timezone_set('Asia/Seoul');// 시간대 설정

$CSAT2025 = "2024-11-14"; //고3

$CSAT2026 = "2025-11-13"; //고2

$CSAT2027 = "2026-11-19"; //고1

$semester = "2024-05-02"; //지필평가


function dday($end_date) {
    $d_day = floor((strtotime($end_date) - strtotime(date('Y-m-d'))) / 86400);
    if ($d_day < 0) {
      $d_day = 0;
    } else {
      return $d_day;
    }
}
