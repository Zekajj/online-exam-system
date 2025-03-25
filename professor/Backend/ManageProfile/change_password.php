<?php
// Retrieve the form data
@include '../../../config.php';

if(isset($_POST['changePasswordBtn'])){
$username = $_POST['usernameToChangePassword'];
$currentPassword = $_POST['current_password'];
$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];

// Validate the form data
// You can add your own validation logic here

// Connect to the database

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the user's current password from the database
// Assuming the table name is "users" and the username is stored in a variable $username
$stmt = $conn->prepare("SELECT Password FROM users WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$hashedPassword = $row['Password'];
$stmt->close();

// Verify the current password
if (md5($currentPassword) === $hashedPassword) {
    // Hash the new password using MD5
    $hashedNewPassword = md5($newPassword);

    // Update the user's password in the database
    $stmt = $conn->prepare("UPDATE users SET Password = ? WHERE Username = ?");
    $stmt->bind_param("ss", $hashedNewPassword, $username);
    $stmt->execute();
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Redirect the user back to the profile page or display a success message
    header("Location: http://localhost/Online-Exam-System/professor/FrontEnd/Profile.php");
} else {
// Invalid current password
echo 'Invalid current password';
  }
}
?>









