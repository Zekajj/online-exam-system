<?php 
    @include '../config.php';

    session_start();

    if(!isset($_SESSION['professorUsername'])){
        header('Location: ../../login.php');
    }   
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
   <link rel="stylesheet" href="navbar.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>    
</head>
<body>
<nav>
    <div class="logo-container col-auto">
        <a href="Dashboard.php"><h3>OXS</h3></a>
        <ul>
            <li><a href="Dashboard.php" class="dashboard active">Dashboard</a></li>
            <li><a href="Exams.php" class="exams">Exams</a></li>
            <li><a href="Results.php" class="results">Results</a></li>
            <li><a href="Students.php" class="students">Students</a></li>
            <li><a href="Subjects.php" class="subjects">Subjects</a></li>
            <li><a href="Profile.php" class="profile">Profile</a></li>
            <li><a href="faqPage.php" class="faqPage">FAQ's</a></li>
        </ul>
    </div>
    <div class="links-container col-auto">
    </div>
    <div class="profile-container col-auto">
        <div >
            <span class="profile-name" style="display:flex; align-items:center;">Hi, <?php echo $_SESSION['professorUsername'] ?>&nbsp; <i onclick="OpenDropdown();" class='bx bx-chevron-down' style="cursor:pointer;font-size:20px;"></i></span>
            <div class="profile-dropdown" style="display:none;">
                <a href="../../logoutLogic.php"><i class='bx bx-exit' ></i>&nbsp;Logout</a>
            </div>

        </div>
    </div>
</nav>


</body>
<script>
    const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
    const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(dropdownToggleEl));

    var profileDropdown = document.querySelector('.profile-dropdown');
    function OpenDropdown(){
        if(profileDropdown.style.display === 'none'){
            profileDropdown.style.display = 'flex';
        }else{
            profileDropdown.style.display = 'none';
        }
    }

</script>
</html>