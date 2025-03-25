<?php 
@include '../../../config.php';

session_start();

if(isset($_POST['editProfileBtn'])){
if (mysqli_connect_error()) {
    echo "Failed to connect to MySQL: " .mysqli_connect_error();
    exit();
}
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$username = $_POST['username'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

$stmt = $conn->prepare("UPDATE users SET FirstName=?, LastName=?, Email=? WHERE Username=?");
$stmt->bind_param("ssss", $firstName, $lastName, $email, $username);
$stmt->execute();

$_SESSION['professorUsername'] = $firstName .' ' .$lastName;

// Close the statement and database connection
$stmt->close();
$conn->close();



header("location: http://localhost/Online-Exam-System/professor/FrontEnd/Profile.php");
// Redirect the user back to the profile page or display a success message

}
?> 