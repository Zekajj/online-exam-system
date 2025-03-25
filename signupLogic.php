<?php
// Load configuration and required libraries
require_once 'config.php';
require_once 'vendor/autoload.php';

// Initialize errors array
$errors = [];

session_start();

// Handle form submission
if (isset($_POST['signupBtn'])) {
    // Validate user input
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $emailAddress = mysqli_real_escape_string($conn, $_POST['emailAddress']);
    $userType = mysqli_real_escape_string($conn, $_POST['userType']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $confirmPassword = md5($_POST['confirmPassword']);

    $userExistsQuery = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $userExistsQuery);

    if (mysqli_num_rows($result) > 0) {
        $errors[] = "User already exists!";
    } else {
        if ($password != $confirmPassword) {
            $errors[] = "Passwords do not match!";
        } else {
            // Insert user into the database
            $sql = "INSERT INTO users (FirstName, LastName, UserType, Email, Username, Password, Status, Created_at)
                    VALUES ('$firstName', '$lastName', '$userType', '$emailAddress', '$username', '$password', '0', NOW())";

            if (mysqli_query($conn, $sql)) {
                $_SESSION["success"] = "Account created successfully. Please login.";
                header('Location: index.php');
                exit();
            } else {
                $errors[] = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>
