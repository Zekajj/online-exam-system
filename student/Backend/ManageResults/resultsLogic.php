<?php 
    @include '../../../config.php';

$examId='';

if(isset($_POST['examId'])){
    $examId = $_POST['examId'];
}
else if(isset($_GET['examId'])){
    $examId = $_GET['examId'];
}
else{
    $examId = '';
}


   $MaxPoints = "Select Sum(Points) as MaxPoints from studentquestions sq join studentexam se
   on sq.StudentExamId = se.Id where StudentExamId = '{$examId}' and se.Student = '{$_SESSION['studentID']}'";

   $Score = "Select Sum(Points) as Score from studentquestions as sq join studentanswers as sa 
    on sa.StudentQuestionId = sq.Id join studentexam se on sq.StudentExamId = se.Id 
    where sq.StudentExamId = '{$examId}' and sa.Status = '1' and sa.SelectedAnswer='1' and se.Student = '{$_SESSION['studentID']}'";


    //Select the count of the correct answers
    $countRightAnswers="Select Count(*) as CorrectAnswers from studentanswers sa join studentquestions sq 
    on sa.StudentQuestionId=sq.Id 
    join studentexam se on sq.StudentExamId = se.Id  
    where sa.Status='1' and sa.SelectedAnswer='1' and sq.StudentExamId = '$examId' and se.Student = '{$_SESSION['studentID']}' ";
    $countRightAnswersResult = mysqli_query($conn, $countRightAnswers);
    $countRightAnswersRow = mysqli_fetch_array($countRightAnswersResult);


    //Select the count of the wrong answers
    $countWrongAnswers="Select Count(*) as WrongAnswers from studentanswers sa join studentquestions sq 
    on sa.StudentQuestionId=sq.Id 
    join studentexam se on sq.StudentExamId = se.Id  
    where sa.Status='0' and sa.SelectedAnswer='1' and sq.StudentExamId = '$examId' and se.Student = '{$_SESSION['studentID']}' ";
    $countWrongAnswersResult = mysqli_query($conn, $countWrongAnswers);
    $countWrongAnswersRow = mysqli_fetch_array($countWrongAnswersResult);

    //Select the count of the answeres that were not answered

   $scoreResult = mysqli_query($conn, $Score);

   $scoreRow = mysqli_fetch_array($scoreResult);

   $maxPointsResult = mysqli_query($conn, $MaxPoints);

   $maxPointsRow = mysqli_fetch_array($maxPointsResult);


   $questions = "Select sq.Id, sq.  Title from studentquestions sq join studentexam se 
   on sq.StudentExamid=se.Id where StudentExamId = '{$examId}' and se.Student='{$_SESSION['studentID']}'";
   $questionResult = mysqli_query($conn, $questions);
?>