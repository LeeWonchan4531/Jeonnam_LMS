<?php
date_default_timezone_set('Asia/Seoul');// 시간대 설정


$date = date("Ymd");

$KEY = ""; //나이스 API 키

$lunchurl = file_get_contents('https://open.neis.go.kr/hub/mealServiceDietInfo?KEY='.$KEY.'&Type=json&ATPT_OFCDC_SC_CODE=F10&SD_SCHUL_CODE=7380037&MMEAL_SC_CODE=2&MLSV_YMD=' . $date);


$dinnerurl = file_get_contents('https://open.neis.go.kr/hub/mealServiceDietInfo?KEY='.$KEY.'&Type=json&ATPT_OFCDC_SC_CODE=F10&SD_SCHUL_CODE=7380037&MMEAL_SC_CODE=3&MLSV_YMD=' . $date);

$Schedule = file_get_contents('https://open.neis.go.kr/hub/SchoolSchedule?KEY='.$KEY.'&ATPT_OFCDC_SC_CODE=F10&SD_SCHUL_CODE=7380037&Type=json&AA_FROM_YMD=' . date("Ymd") . '&AA_TO_YMD=' . date("Y-m-d", strtotime("+3 days")));

//DDISH_NM: 메뉴
//CAL_INFO: 칼로리
function lunch($key, $json)
{



    $data = json_decode($json, true); // JSON 문자열을 PHP 배열로 변환

    if (isset($data['mealServiceDietInfo'])) { // 'mealServiceDietInfo' 키가 있는지 확인
        $mealServiceDietInfo = $data['mealServiceDietInfo']; // mealServiceDietInfo 배열을 가져옴

        foreach ($mealServiceDietInfo as $info) { // mealServiceDietInfo 배열 각 요소에 대해
            if (isset($info['row'])) { // 'row' 키가 있는지 확인
                foreach ($info['row'] as $row) { // 'row' 배열 각 요소에 대해
                    if (isset($row[$key])) { // $key 키가 있는지 확인
                        echo $row[$key]; // $key 값을 출력
                    }
                }
            }
        }
    } else {
        echo "급식 정보가 없습니다"; // 'mealServiceDietInfo' 키가 없을 경우 메시지를 출력
    }
}


function dinner($key, $json)
{


    $data = json_decode($json, true); // JSON 문자열을 PHP 배열로 변환

    if (isset($data['mealServiceDietInfo'])) { // 'mealServiceDietInfo' 키가 있는지 확인
        $mealServiceDietInfo = $data['mealServiceDietInfo']; // mealServiceDietInfo 배열을 가져옴

        foreach ($mealServiceDietInfo as $info) { // mealServiceDietInfo 배열 각 요소에 대해
            if (isset($info['row'])) { // 'row' 키가 있는지 확인
                foreach ($info['row'] as $row) { // 'row' 배열 각 요소에 대해
                    if (isset($row[$key])) { // $key 키가 있는지 확인
                        echo $row[$key]; // $key 값을 출력
                    }
                }
            }
        }
    } else {
        echo "급식 정보가 없습니다"; // 'mealServiceDietInfo' 키가 없을 경우 메시지를 출력
    }
}



function schedule($json)
{



    $data = json_decode($json, true);


    $event1 = isset($data["SchoolSchedule"][1]["row"][0]["EVENT_NM"]) ? $data["SchoolSchedule"][1]["row"][0]["EVENT_NM"] : "아무 일이 없네요.."; //오늘
    $event2 = isset($data["SchoolSchedule"][1]["row"][1]["EVENT_NM"]) ? $data["SchoolSchedule"][1]["row"][1]["EVENT_NM"] : "아무 일이 없네요.."; //내일
    $event3 = isset($data["SchoolSchedule"][1]["row"][1]["EVENT_NM"]) ? $data["SchoolSchedule"][1]["row"][2]["EVENT_NM"] : "아무 일이 없네요.."; //모레
    $event4 = isset($data["SchoolSchedule"][1]["row"][1]["EVENT_NM"]) ? $data["SchoolSchedule"][1]["row"][3]["EVENT_NM"] : "아무 일이 없네요.."; //글피

    echo "<p>오늘: " . $event1 . "</p>";
    echo "<p>내일: " . $event2 . "</p>";
    echo "<p>모레: " . $event3 . "</p>";
    echo "<p>글피: " . $event4 . "</p>";
}

