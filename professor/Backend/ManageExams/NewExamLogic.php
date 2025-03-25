<?php 
   @include '../../../config.php';

    $fromDate = isset($_POST['From']) ? date('Y-m-d', strtotime($_POST['From'])) : date('Y-m-d');
    $toDate = isset($_POST['To'])? date('Y-m-d', strtotime($_POST['To'])) : date('Y-m-d');
    if(isset($_POST['createExam'])){
        $examTitle = isset($_POST['exam-title']) ? $_POST['exam-title'] : '';
        $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
        $startDate = isset($_POST['startDate']) ? date('Y-m-d H:i:s', strtotime($_POST['startDate'])) : '';
        $duration = isset($_POST['duration']) ? $_POST['duration'] : '';
        $professorId = $_SESSION['professorID'];

        $sql = "INSERT INTO exam (Subject, Professor, Title, StartDate, Duration,Status, Created_at) 
        VALUES ('$subject', '$professorId', '$examTitle', '$startDate', '$duration', '2' , NOW())";
        if(mysqli_query($conn,$sql)){
            ?>
            <script>
                Swal.fire(
                    'Exam created successfully',
                    '',
                    'success'
                )
            </script> 
            
<?php 
        }
    }
    $examTable = "SELECT e.Id, s.Name as SubjectName, CONCAT(u.FirstName, ' ', u.LastName) as Professor,  e.Title, e.StartDate, e.Duration, e.Status 
    FROM exam e join users u on e.Professor = u.Id 
    join subject s on e.Subject = s.Id where DATE(e.Created_at) >= '$fromDate' and DATE(e.Created_at) <= '$toDate'";

    $resultExamTable = mysqli_query($conn,$examTable); 
?>