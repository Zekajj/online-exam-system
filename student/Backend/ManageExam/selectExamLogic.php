<?php
    @include '../../../config.php';

    $examId = $_POST['examId'];

    $sql = "SELECT e.Id AS ExamId, e.Title AS ExamName, s.Name as Subject, 
    CONCAT(u.FirstName, ' ', u.LastName) AS Professor, StartDate, Duration  
FROM exam AS e 
JOIN subject s ON e.Subject = s.Id 
JOIN users u ON e.Professor = u.Id where e.Id = '{$examId}'";

$examResult = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($examResult);

$data = array(
    "Subject" => $row['Subject'],
    "Professor" => $row['Professor'],
    "StartDate" => $row['StartDate'],
    "Duration" => $row['Duration'],
    "ExamId" => $row['ExamId'],
);

echo json_encode($data);

?>