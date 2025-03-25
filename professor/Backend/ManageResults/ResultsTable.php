<?php
@include '../../../config.php';

if(isset($_POST['submitResultsBtn'])){
    $examId = isset($_POST['examId']) ? $_POST['examId'] : '';

    $maxPoints = "SELECT SUM(Points) as MaxPoints
                  FROM studentquestions sq
                  JOIN studentexam se ON sq.StudentExamId = se.Id
                  WHERE se.ExamId = '{$examId}'
                  group BY se.Id";
    $maxResult = mysqli_query($conn, $maxPoints);
    if ($maxResult !== false) {
        if (mysqli_num_rows($maxResult) > 0) {
            $maxRow = mysqli_fetch_array($maxResult);
        } else {
            $maxRow = null;
    } 
    
    $selectResultsTable = "SELECT se.Id as StudentExamId, u.Id as StudentId, CONCAT(FirstName, ' ', LastName) as StudentName
                           FROM studentexam se 
                           JOIN users u ON se.Student = u.Id
                           WHERE se.ExamId = '{$examId}'
                           group by se.Id";
    
    $selectResults = mysqli_query($conn, $selectResultsTable);

}}

?>
