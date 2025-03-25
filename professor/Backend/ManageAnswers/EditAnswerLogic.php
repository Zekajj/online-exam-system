<?php
  @include '../../../config.php';

  if(isset($_POST['saveEditAnswer'])){
    $answerId =  $_POST['answerIdForEditAnswer'];
    $answer = $_POST['editAnswer'];
    $status = isset($_POST['editAnswerStatus']) ? $_POST['editAnswerStatus'] : '0';

    $sql = "UPDATE answers SET Title='$answer', Status='$status' WHERE Id='$answerId'";
    if(mysqli_query($conn,$sql)){
      echo "success";
    } else {
      echo "failed";
    }
  }
?>