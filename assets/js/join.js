function nextQuestion(questionNumber) {
    var currentQuestion = document.getElementById("question-" + questionNumber);
    var nextQuestion = document.getElementById("question-" + (questionNumber + 1));
  
    // 질문 비활성화
    currentQuestion.classList.remove("active");
  
    // 질문 활성화
    if (nextQuestion) {
      nextQuestion.classList.add("active");
    }
  }

// 첫 번째 질문 활성화
document.getElementById("question-1").classList.add("active");
window.onload = function () {
  document.body.classList.add("fade-in");
};

//바코드 인식 및 카메라 선택
const {
  BrowserMultiFormatReader,
  NotFoundException,
  ChecksumException,
  FormatException,
} = window.ZXing;

const video = document.getElementById("video");
const cameraList = document.getElementById("cameraList");
const startButton = document.getElementById("startButton");
const resultElement = document.getElementById("result");
const codeReader = new BrowserMultiFormatReader();

navigator.mediaDevices.enumerateDevices().then((devices) => {
  devices.forEach((device) => {
    if (device.kind === "videoinput") {
      let option = document.createElement("option");
      option.value = device.deviceId;
      option.text = device.label;
      cameraList.appendChild(option);
    }
  });
});

startButton.addEventListener("click", () => {
  navigator.mediaDevices.getUserMedia({ video: true })
    .then(function(stream) {
      // 권한이 허용되면, 비디오 스트림을 사용할 수 있습니다.
      video.srcObject = stream;

      let selectedDeviceId = cameraList.value;
      codeReader.decodeFromVideoDevice(selectedDeviceId, video, (result, error) => {
        if (result) {
          // 바코드 인식에 성공한 경우, 인식된 바코드의 정보를 웹 페이지에 출력
          resultElement.innerText = "바코드 인식 결과: " + result.text;

          // 이름, 학년, 반, 번호 값 로드
          var name = document.querySelector(".name").value;
          var grade = document.querySelector('input[name="grade"]').value;
          var password = document.querySelector('input[name="password"]').value;
          var classNumber = document.querySelector('input[name="classNumber"]').value;
          var studentNumber = document.querySelector('input[name="studentNumber"]').value;

          var form = document.getElementById("barcode-form");
          form.elements["name"].value = name;
          form.elements["grade"].value = grade;
          form.elements["password"].value = password;
          form.elements["classNumber"].value = classNumber;
          form.elements["studentNumber"].value = studentNumber;
          form.elements["barcode"].value = result.text;

          // 보내기
          form.submit();
        }
        if (
          error &&
          !(
            error instanceof NotFoundException ||
            error instanceof ChecksumException ||
            error instanceof FormatException
          )
        ) {
          console.error(error);
        }
      });
    })
    .catch(function(err) {
      // 권한이 거부되거나 오류가 발생한 경우 처리
      alert('카메라 권한을 허용해주세요.');
    });
});
// '다음' 버튼을 클릭했을 때의 이벤트 핸들러를 추가
document
  .getElementById("submit-barcode")
  .addEventListener("click", function (event) {
    // 이름, 학년, 반, 번호 값 로드.
    var name = document.querySelector(".name").value;
    var grade = document.querySelector('input[name="grade"]').value;
    var password = document.querySelector('input[name="password"]').value;
    var classNumber = document.querySelector('input[name="classNumber"]').value;
    var studentNumber = document.querySelector(
      'input[name="studentNumber"]'
    ).value;

    // 수동으로 입력한 바코드 값 로드.
    var barcode = document.querySelector('input[name="barcode"]').value;

    if (!name || !grade || !classNumber || !studentNumber || !password || !barcode) {
      // 유효하지 않은 경우, 경고 메시지를 출력하고 이벤트를 중지
      alert("모든 필드를 채워주세요.");
      event.preventDefault();
      return;
    }

    var form = document.getElementById("barcode-form");
    form.elements["name"].value = name;
    form.elements["grade"].value = grade;
    form.elements["password"].value = password;
    form.elements["classNumber"].value = classNumber;
    form.elements["studentNumber"].value = studentNumber;
    form.elements["barcode"].value = barcode;

    // 보내기
    form.submit();
  });


  //검증
  function isValidInput(questionElement) {
    var inputFields = questionElement.querySelectorAll("input");
    return Array.from(inputFields).every(function (inputField) {
      // 바코드 입력 필드도 검증하도록 수정
      return inputField.value || inputField.name === "barcode";
    });
  }

// 모든 '다음' 버튼에 이벤트 리스너를 추가
var nextButtons = document.querySelectorAll(".blue-button");
nextButtons.forEach(function (button, index) {
  button.addEventListener("click", function () {
    var currentQuestion = button.parentElement;
    var nextQuestion = document.getElementById("question-" + (index + 2));

    // 입력 값이 유효한지 검증
    if (isValidInput(currentQuestion)) {
      // 유효한 경우, 현재 질문을 페이드아웃
      currentQuestion.classList.add("fade-out");

      // 페이드아웃 애니메이션이 끝나면 다음 질문을 활성화
      currentQuestion.addEventListener("transitionend", function () {
        currentQuestion.classList.remove("active", "fade-out");

        if (nextQuestion) {
          nextQuestion.classList.add("active");
        }
      });
    } else {
      // 유효하지 않은 경우, 경고 메시지를 출력
      alert("모든 필드를 채워주세요.");
    }
  });
});


// JavaScript
function handleNext(questionNumber) {
  var currentQuestion = document.getElementById("question-" + questionNumber);

  // 입력 값이 유효한지 확인
  if (isValidInput(currentQuestion)) {
    // 유효한 경우, 다음 질문으로 넘어갑니다.
    nextQuestion(questionNumber);
  } else {
    // 유효하지 않은 경우, 경고 메시지를 출력하고 다음 질문으로 넘어가지 않습니다.
    alert("모든 필드를 채워주세요.");
  }
}

  window.onload = function () {
    var firstQuestion = document.getElementById("question-1");
    firstQuestion.classList.add("active");
  };



  function handleOnInput(el, maxlength) {
    if(el.value.length > maxlength)  {
      el.value 
        = el.value.substr(0, maxlength);
    }
  }


  if ("serviceWorker" in navigator) {
    window.addEventListener("load", () => {
        navigator.serviceWorker.register("/service-worker.js");
    });
}
