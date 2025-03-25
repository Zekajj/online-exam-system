<?php
    @include '../../../config.php';
if (mysqli_connect_error()) {
    echo "Failed to connect to MySQL: " .mysqli_connect_error();
    exit();
}

$professorId = $_SESSION['professorID'];


# Query the database
$Exams = "SELECT * FROM exam WHERE DATE_ADD(`StartDate`, INTERVAL `Duration` MINUTE) < NOW()";
$ExamHistory = mysqli_query($conn, $Exams);
$professor = "SELECT Id,CONCAT(FirstName,' ',LastName) as professorName,Email,Status FROM users where UserType = '0' and Id='$professorId'";
$Professors = mysqli_query($conn, $professor);

$user = "SELECT Id,FirstName, LastName,Email, Username ,Status FROM users where UserType = '0' and Id = '$professorId'";

$profesori = mysqli_query($conn, $user);

?>