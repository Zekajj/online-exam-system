<?php
@include '../../../config.php';

session_start();


if(isset($_POST['saveAnswer'])){
    $answer = isset($_POST['answer']) ? $_POST['answer'] : '';
    $answerStatus = isset($_POST['answerStatus']) ? $_POST['answerStatus'] : '0'; // set answerStatus to 0 if checkbox is unchecked
    $questionIdForAddAnswer = isset($_POST['questionIdForAddAnswer']) ? $_POST['questionIdForAddAnswer'] : '';
    $professorId = $_SESSION['professorID'];

    // Insert the new answer 
    $sql_question = "INSERT INTO answers (QuestionId, Professor, Title, Status, Created_at)
                     VALUES ('{$questionIdForAddAnswer}', '{$professorId}', '{$answer}', '{$answerStatus}', NOW())";

    $answerTable = "SELECT * FROM answers WHERE QuestionId = '{$questionIdForAddAnswer}' AND Status = '1'";

    $error = "There can only be one correct answer per question";

    $resultAnswerTable = mysqli_query($conn,$answerTable);
    if(mysqli_num_rows($resultAnswerTable) == 0 || $answerStatus == '0'){ // check if answer status is 0
        if(mysqli_query($conn, $sql_question)){       
      } else {
            echo "Error: " . $sql_question . "<br>" . mysqli_error($conn);
        }
    }
    else{
        echo $error;
    }
}


?>

