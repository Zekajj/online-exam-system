<?php @include 'config.php';

session_start();

$sql = "SELECT * FROM users";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        if ($row['UserType'] == '0' && $row['Id'] == $_SESSION['professorID']) {
            $updateProfessor = "UPDATE users SET Status='0' WHERE Id='{$_SESSION['professorID']}' AND UserType='0'";
            mysqli_query($conn, $updateProfessor);
            setcookie('remember_professor', '', time() - 86400, '/');
        }
        if ($row['UserType'] == '1' && $row['Id'] == $_SESSION['studentID']) {
            $updateStudent = "UPDATE users SET Status='0' WHERE Id='{$_SESSION['studentID']}' AND UserType='1'";
            mysqli_query($conn, $updateStudent);
            setcookie('remember_student', '', time() - 86400, '/');
        }
    }
    session_unset();
    session_destroy(); 
}
    header('location: index.php');

?>
