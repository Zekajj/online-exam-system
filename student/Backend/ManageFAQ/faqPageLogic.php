<?php 
   @include '../../../config.php';
    
   if(isset($_POST['askQuestion'])){
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];
    $userId = $_SESSION['studentID'];
    $question = $_POST['question'];

    // Insert form data into the SQL table
   
    $sql =  " INSERT INTO faq (FirstName, LastName, Email, UserId, Question) 
            VALUES ('$firstName', '$lastName', '$emailAddress', '$userId', '$question')";
    if(mysqli_query($conn,$sql)){
        ?>
        <script>
            Swal.fire(
                'Exam created successfully',
                '',
                'success'
            );
        </script> 
        <?php
    }
}
?>
