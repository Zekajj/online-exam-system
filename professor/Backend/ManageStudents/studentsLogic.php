<?php
    @include '../config.php';
if (mysqli_connect_error()) {
    echo "Failed to connect to MySQL: " .mysqli_connect_error();
    exit();
}

# Query the database
$allStudents = "SELECT Id,CONCAT(FirstName,' ',LastName) as StudentName,Email,Status FROM users where UserType = '1'";
$studentResultTable = mysqli_query($conn, $allStudents);

?>