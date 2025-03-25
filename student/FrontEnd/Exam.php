<?php 
    @include '../../config.php';

    session_start();

    if(!isset($_SESSION['studentUsername'])){
        header('Location: login.php');
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js"></script>
    <link rel="stylesheet" href="exam.css"/>
    <title>Exam</title>
</head>
<body style="background:#f1f1f3;">
    <?php @include 'studentNavbar.php'?>
    <?php require '../Backend/ManageExam/generateExam.php'?>
    <?php require '../Backend/ManageExam/submitExam.php' ?>
    <div style="margin:1.5rem 8rem;" class="mainContainer">
    <div class="secondaryContainer col-9">
      <form action="" method="post" id="examForm">
        <input type="text" hidden name="subject" value="<?php echo $examRow['Subject'] ?>">
        <input type="text" hidden name="professor" value="<?php echo  $examRow['Professor'] ?>">
  
        <?php 
        
        while($questionRow = mysqli_fetch_array($questionResult)){ ?>
        <div class="examContainer">
            <div class="questionContainer">
                <div class="questionPoints">
                    <span>
                      Question 
                      <input type="text" value="<?php echo $questionRow['Id']; ?>" readonly name="questionId" style="font-size:14px;outline:none;text-align:start; background:none;border:none;color:gray;">
                    </span>
                    <span>
                      <input type="text" id="questionPoints" value="<?php echo $questionRow['Points']; ?>" readonly name="questionPoints" style="font-size:14px;outline:none;text-align:end;color:gray;background:none;border:none;">
                      points</span>
                </div>
                <div class="questionTitle">
                    <textarea name="question" readonly id="" cols="30"><?php echo $questionRow['Title'] ?></textarea>
                </div>
            </div>
            <?php  $answers ="SELECT * from studentanswers where StudentQuestionId = '{$questionRow['Id']}'";
                   $answerResult = mysqli_query($conn, $answers);
                   while($answerRow = mysqli_fetch_array($answerResult)){
            ?>
            <div class="answerContainer">
                <div class="answer">
                    <input type="checkbox" value ="<?php echo $answerRow['Id'] ?>" name="checkedAnswer[]" class="form-check-input col-2">
                    <div class="col-12">
                        <textarea name="answer" readonly id="" cols="30"><?php echo $answerRow['Title'] ?></textarea>
                    </div>
                </div>
            </div>
            <?php }?>
          <input type="text" hidden name="totalPoints" value="<?php echo $totalPoints ?>">
        </div>
        <?php 
            }
          ?>

        <div class="submitExamContainer">
          <button type="submit" name="submitExam">Submit exam</button>
        </div>
        </form>
    </div>
    <div class="examStatusContainer col-3">
        <div>

            <h2 style="margin:0;padding:0;border-bottom:1px solid lightgray">Exam Name</h2>
            <div id="timer">
            </div>
        <div>
            <?php
            $examId = $_GET['examId'];
            $getExam = "SELECT Time(e.StartDate) AS ExamTime, TIME_TO_SEC(TIMEDIFF(ADDTIME(e.StartDate, SEC_TO_TIME(e.Duration * 60)) , NOW())) AS RemainingTime,  Concat(FirstName, ' ', LastName) as Professor, s.Name as Subject ,  Time(ADDTIME(e.StartDate, SEC_TO_TIME(e.Duration * 60))) AS EndTime,
             e.Duration FROM studentexam se join exam e on se.ExamId = e.Id join users u on se.Professor = u.Id join subject s on se.Subject=s.Id 
             WHERE se.Id = '$examId'";
            $getExamResult = mysqli_query($conn, $getExam);
            $getExamRow = mysqli_fetch_array($getExamResult);
            $examTime = $getExamRow['ExamTime'];
            $duration = $getExamRow['Duration'];
            $endTime = $getExamRow['EndTime'];
            $remainingTime = $getExamRow['RemainingTime'];
            
            ?>
            <div class="examSpecifications">
                <i class="fa-regular fa-clock" style="color:#f7b092; border-radius:50% "></i>
                    <div>
                        <span style="font-size: 15px; ">
                            Start time - End time
                        </span>
                        <span class="time" style="font-size: 13px;">
                          <?php echo $examTime?> - <?php echo $endTime?> 
                        </span>
                    </div>
                </div>
            <div class="examSpecifications">
                <i class="fa-solid fa-book" style="color:#e96d7f;"></i>
                <div>
                    <span>
                        Subject
                    </span>
                    <span style="font-size: 13px; ">
                        <?php echo $getExamRow['Subject'] ?>
                    </span>
                </div>
            </div>
            <div class="examSpecifications">
                    <i class="fa-solid fa-user-tie" style="color:#53b7ec;"></i>
                <div>
                    <span>
                        Professor
                    </span>
                    <span style="font-size:13px;">
                    <?php echo $getExamRow['Professor'] ?>
                    </span>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>






    <script>

      
        $(document).ready(function() {
            $('nav .logo-container ul li a.dashboard').removeClass('active');
            $('nav .logo-container ul li a.results').removeClass('active');
            $('nav .logo-container ul li a.profile').removeClass('active');
            $('nav .logo-container ul li a.faqPage').removeClass('active');
        })
        function updateTextareaRows(textarea, text) {
  // Create a temporary textarea to calculate the number of rows needed
          const tempTextarea = document.createElement('textarea');
          tempTextarea.style.position = 'absolute';
          tempTextarea.style.top = '-9999px';
          tempTextarea.style.left = '-9999px';
          tempTextarea.style.width = `${textarea.clientWidth}px`;
          tempTextarea.style.fontSize = window.getComputedStyle(textarea).getPropertyValue('font-size');
          tempTextarea.style.lineHeight = window.getComputedStyle(textarea).getPropertyValue('line-height');
          tempTextarea.style.fontFamily = window.getComputedStyle(textarea).getPropertyValue('font-family');
          tempTextarea.style.padding = window.getComputedStyle(textarea).getPropertyValue('padding');
          tempTextarea.style.border = window.getComputedStyle(textarea).getPropertyValue('border');
          tempTextarea.style.boxSizing = window.getComputedStyle(textarea).getPropertyValue('box-sizing');
          tempTextarea.value = text;
          document.body.appendChild(tempTextarea);

          // Set the number of rows based on the textarea content
          const contentHeight = tempTextarea.scrollHeight - parseInt(window.getComputedStyle(tempTextarea).getPropertyValue('padding-top')) - parseInt(window.getComputedStyle(tempTextarea).getPropertyValue('padding-bottom'));
          textarea.rows = Math.max(1, Math.ceil(contentHeight / parseFloat(window.getComputedStyle(textarea).getPropertyValue('line-height'))));

          // Remove the temporary textarea from the document
          document.body.removeChild(tempTextarea);
      }
      const textarea = document.querySelectorAll('textarea');
      $(document).ready(function(){
        textarea.forEach(function(ta) {
          updateTextareaRows(ta, ta.value);
        });
      });



const FULL_DASH_ARRAY = 283;
const WARNING_THRESHOLD = 10;
const ALERT_THRESHOLD = 5;

const COLOR_CODES = {
  info: {
    color: "green"
  },
  warning: {
    color: "orange",
    threshold: WARNING_THRESHOLD
  },
  alert: {
    color: "red",
    threshold: ALERT_THRESHOLD
  }
};


//Get the remaining time

const TIME_LIMIT = <?php echo $remainingTime ?>;
let timePassed = 0;
let timeLeft = TIME_LIMIT;
let timerInterval = null;
let remainingPathColor = COLOR_CODES.info.color;

document.getElementById("timer").innerHTML = `
<div class="base-timer">
  <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <g class="base-timer__circle">
      <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
      <path
        id="base-timer-path-remaining"
        stroke-dasharray="283"
        class="base-timer__path-remaining ${remainingPathColor}"
        d="
          M 50, 50
          m -45, 0
          a 45,45 0 1,0 90,0
          a 45,45 0 1,0 -90,0
        "
      ></path>
    </g>
  </svg>
  <span id="base-timer-label" class="base-timer__label">${formatTime(
    timeLeft
  )}</span>
</div>
`;

startTimer();

function onTimesUp() {
  clearInterval(timerInterval);
}

function startTimer() {
  timerInterval = setInterval(() => {
    timePassed = timePassed += 1;
    timeLeft = TIME_LIMIT - timePassed;
    document.getElementById("base-timer-label").innerHTML = formatTime(
      timeLeft
    );
    setCircleDasharray();
    setRemainingPathColor(timeLeft);

    if (timeLeft === 0) {
      onTimesUp();
    }
  }, 1000);
}

function formatTime(time) {
  const minutes = Math.floor(time / 60);
  let seconds = time % 60;

  if (seconds < 10) {
    seconds = `0${seconds}`;
  }

  return `${minutes}:${seconds}`;
}

function setRemainingPathColor(timeLeft) {
  const { alert, warning, info } = COLOR_CODES;
  if (timeLeft <= alert.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(warning.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(alert.color);
  } else if (timeLeft <= warning.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(info.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(warning.color);
  }
}

function calculateTimeFraction() {
  const rawTimeFraction = timeLeft / TIME_LIMIT;
  return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
}

function setCircleDasharray() {
  const circleDasharray = `${(
    calculateTimeFraction() * FULL_DASH_ARRAY
  ).toFixed(0)} 283`;
  document
    .getElementById("base-timer-path-remaining")
    .setAttribute("stroke-dasharray", circleDasharray);
}
    </script>
</body>
</html>