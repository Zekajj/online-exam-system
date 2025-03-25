<?php
 @include '../../../config.php';
 if(isset($_POST['addSubject'])){
    $subjectName=isset($_POST['subjectName']) ? $_POST['subjectName'] : '';
    $sql="INSERT INTO subject (Name,Created_at)values( '$subjectName',NOW())";
    if(mysqli_query($conn,$sql)){
        ?>
        <script>
            Swal.fire(
                'Subject created successfully',
                '',
                'success'
            )
    </script>
<?php 
     }
} 
$subjectTable = "SELECT Id, Name, Created_at from subject";
$resultSubjectTable = mysqli_query($conn,$subjectTable);

?>