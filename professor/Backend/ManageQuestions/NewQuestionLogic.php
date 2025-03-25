<?php
    include '../../../config.php';

    session_start();

    if(isset($_POST['saveQuestion'])){
        $question = isset($_POST['question']) ? $_POST['question'] : '';
        $points = isset($_POST['points']) ? $_POST['points'] : '1';
        $examId = isset($_POST['examIdForAddQuestion']) ? $_POST['examIdForAddQuestion'] : '';
        $professorId = $_SESSION['professorID'];

        // Get the subject of the exam
        $subjectQuery = "SELECT Subject FROM exam WHERE Id='{$examId}'";
        $subjectResult = mysqli_query($conn, $subjectQuery);
        $subject = mysqli_fetch_array($subjectResult)[0];

        // Insert the new question
        $sql_question = "INSERT INTO questions (ExamId, Subject, Professor, Title, Points, Created_at)
                         VALUES ('{$examId}', '{$subject}', '{$professorId}', '{$question}', {$points}, NOW())";

        if(mysqli_query($conn, $sql_question)){
?>
            <script>
                Swal.fire(
                    'Question saved successfully',
                    '',
                    'success'
                )
            </script>
<?php
        } else {
            echo "Error: " . $sql_question . "<br>" . mysqli_error($conn);
        }
    }
?>
