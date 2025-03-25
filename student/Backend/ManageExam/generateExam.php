<?php 
@include '../../../config.php';

$examId = $_GET['examId'];
$totalPoints = 0;
$exam = "SELECT * from studentexam where Id='$examId'";
$examResult = mysqli_query($conn, $exam);
$examRow = mysqli_fetch_array($examResult);

$question = "SELECT * from studentquestions where StudentExamId='$examId'";
$questionResult = mysqli_query($conn, $question);
?>