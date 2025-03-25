<?php
    @include '../config.php';
    if (mysqli_connect_error()) {
        echo "Failed to connect to MySQL: " .mysqli_connect_error();
        exit();
    }

    # Query the database
    $newStudents = "SELECT Id, CONCAT(FirstName,' ',LastName) as StudentName, Email, Status FROM users WHERE UserType = '1' AND Created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() ";
    $NewstudentResultTable = mysqli_query($conn, $newStudents);
?>