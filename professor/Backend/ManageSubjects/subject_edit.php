<?php
 @include '../../../config.php';

// check if the form was submitted

  // retrieve the subject ID and updated information from the form data
  $subjectId = $_POST['editSubjectId'];
  $subjectName = $_POST['editSubjectName'];

  if (!$conn) {
    die("Error: Connection failed. " . mysqli_connect_error());
  }

  // update the subject information in the database
  $query = "UPDATE subject SET Name='$subjectName' WHERE Id='$subjectId'";
mysqli_query($conn, $query);

  // close the database connection
  mysqli_close($conn);
?>