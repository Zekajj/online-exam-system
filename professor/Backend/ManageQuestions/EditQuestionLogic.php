<?php
  @include '../../../config.php';

  if(isset($_POST['update-question'])){
    $questionId =  $_POST['questionId'];
    $updateQuestion = $_POST['update-question-title'];
    $questionPoints = $_POST['questionPoints'];

    $sql = "UPDATE questions SET Title='$updateQuestion', Points='$questionPoints' WHERE Id='$questionId'";
    if(mysqli_query($conn,$sql)){
      echo "success";
    } else {
      echo "failed";
    }
  }
?>