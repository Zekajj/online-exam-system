<?php
    @include '../../../config.php';

    $studentId = $_SESSION['studentID'];

    $Exams = "SELECT * FROM exam WHERE DATE_ADD(`StartDate`, INTERVAL `Duration` MINUTE) < NOW()";
$ExamHistory = mysqli_query($conn, $Exams);
$student = "SELECT Id,CONCAT(FirstName,' ',LastName) as studentName,Email,Status FROM users where UserType = '1' and Id= '$studentId'";
$Students = mysqli_query($conn, $student);

    $user = "SELECT Id,FirstName, LastName,Email, Username ,Status FROM users where UserType = '1' and Id = '$studentId'";

    $studenti = mysqli_query($conn, $user);


?>