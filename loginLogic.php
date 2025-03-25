<?php 
    @include 'config.php';

    session_start();

// Check for remember_user cookie
    if(isset($_COOKIE['remember_professor'])) {
    // Get user details from database using cookie value
        $professorId = mysqli_real_escape_string($conn, $_COOKIE['remember_professor']);
        $sql = "SELECT * FROM users WHERE Id = '$professorId' and verificationStatus='1'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            if($row['UserType'] == '0'){
                $_SESSION['professorUsername'] = $row['FirstName'] .' ' .$row['LastName'];
                $_SESSION['professorID'] = $row['Id'];
                $update = "UPDATE users SET Status='1' WHERE Id={$_SESSION['professorID']} and UserType='0'" ;
                mysqli_query($conn, $update);
                header("Location:professor/FrontEnd/Dashboard.php");
            }
        }
    }
    if(isset($_COOKIE['remember_student'])) {
        $studentId = mysqli_real_escape_string($conn, $_COOKIE['remember_student']);
        $sql = "SELECT * FROM users WHERE Id = '$studentId' and verificationStatus='1'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            if($row['UserType'] == '1'){
                $_SESSION['studentUsername'] = $row['FirstName'] .' ' .$row['LastName'];
                $_SESSION['studentID'] = $row['Id'];
                $update = "UPDATE users SET Status='1' WHERE Id={$_SESSION['studentID']} and UserType='1' ";
                mysqli_query($conn, $update);
                header('Location: student/FrontEnd/Dashboard.php');
            }
        }
    }


    if(isset($_POST['loginBtn'])){
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = md5($_POST['password']);

        $sql = "Select * from users where Username='$username' and Password='$password' ";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)> 0){
            $row = mysqli_fetch_array($result);
            if($row['UserType'] == '0'){
                $_SESSION['professorUsername'] = $row['FirstName'] .' ' .$row['LastName'];
                $_SESSION['professorID'] = $row['Id'];
                $update = "UPDATE users SET Status='1' WHERE Id={$_SESSION['professorID']} and UserType='0' ";
                mysqli_query($conn, $update);
                // Set cookie to remember user
                setcookie('remember_professor', $row['professorID'], time() + 86400, "/");
                header("Location:professor/FrontEnd/Dashboard.php");
            }
            elseif($row['UserType'] == '1'){
                $_SESSION['studentUsername'] = $row['FirstName'] .' ' .$row['LastName'];
                $_SESSION['studentID'] = $row['Id'];
                $update = "UPDATE users SET Status='1' WHERE Id={$_SESSION['studentID']} and UserType='1'";
                mysqli_query($conn, $update);
                // Set cookie to remember user
                setcookie('remember_student', $row['Id'], time() + 86400, "/");
                header('Location: student/FrontEnd/Dashboard.php');
            }
        }
    }
?>
