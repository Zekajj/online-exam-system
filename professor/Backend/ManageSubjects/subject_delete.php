<?php
// connect to the database

@include '../../../config.php';

// get the subject ID from the frontend
$subjectId = $_POST['subjectId'];

// delete the subject from the database
$sql = "DELETE FROM subject where Id = $subjectId";
mysqli_query($conn,$sql);
?>