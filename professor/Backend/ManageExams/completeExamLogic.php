<?php
    @include '../../../config.php';

    $examId = isset($_POST['examIdToCompleteExam']) ? $_POST['examIdToCompleteExam'] : '';

    $sql = "Update exam set Status = '1' where Id = '{$examId}'";
    $sql3 = "Update studentexam set Status = '1' where ExamId = '{$examId}'";

    $sql1 = "Update exam set Status='0' where Status = '1' and Id != '{$examId}'"; 
    $sql2 = "Update studentexam set Status='0' where Status = '1' and ExamId != '{$examId}'"; 

    mysqli_query($conn, $sql);
    mysqli_query($conn, $sql1);
    mysqli_query($conn, $sql2);
    mysqli_query($conn, $sql3);

?>