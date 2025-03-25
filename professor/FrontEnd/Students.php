<?php 
   @include '../../config.php';

    session_start();

    if(!isset($_SESSION['professorUsername'])){
        header('Location:../../login.php');
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Students.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body style="background:#f1f1f3;">
    <?php @include 'navbar.php' ?>
    
    
<section>
<div class="pageTitleContainer" >   
               <div>
                    <h2>
                    <?php
                          $currentPage = basename($_SERVER['PHP_SELF']);
                          $pageTitle = str_replace(".php", "", $currentPage);
                          echo $pageTitle;  
                    ?>
                    </h2>
               </div>
</div>
    <div class="filters">
        <div><form id="AllStudentsForm" method="POST"><input id="AllstudentFilter" type="search" placeholder="Search student" /></form></div>
        <div>
            <select>
                <option>All</option>
            </select>
            <button>
                Filter&nbsp;<i class="bi bi-filter"></i>
            </button>
        </div>
    </div>
<div class="Allstudents">
  <?php
       @include '../config.php';
       if (mysqli_connect_error()) {
           echo "Failed to connect to MySQL: " .mysqli_connect_error();
           exit();
       }
       
       # Query the database
       $allStudents = "SELECT Id,CONCAT(FirstName,' ',LastName) as StudentName,Email,Status FROM users where UserType = '1'";
       $studentResultTable = mysqli_query($conn, $allStudents);

         ?>
    <?php if(mysqli_num_rows($studentResultTable) == 0){?>
        <span class="text-danger">No results</span>
      <?php } 
        if(mysqli_num_rows($studentResultTable)> 0){
        ?>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Student Name</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
        <?php while($studentRow = mysqli_fetch_array($studentResultTable)) {
          ?>
          <tr>
            <td><?php echo $studentRow['Id'] ?></td>
            <td><?php echo $studentRow['StudentName'] ?></td>
            <td><?php echo $studentRow['Email']?></td>
            <td><span><?php if($studentRow['Status'] == '1'){
              echo 'Online';
            }
            else{
              echo 'Offline';
            } 
            ?></span></td>
          </tr>
          <?php } }?>
        </tbody>
</table>
</div>


<div style="margin:2rem 8rem 1rem 8rem;"><span style="font-size:1.5rem; border-bottom:3px solid #f7b092;">New Students</span></div>

<div class="filters">
        <div><form id="NewStudentsForm" method="POST"><input type="search" placeholder="Search student" /></form></div>
        <div>
            <select>
                <option>All</option>
            </select>
            <button>
                Filter&nbsp;<i class="bi bi-filter"></i>
            </button>
        </div>
    </div>

<div class="NewStudents">
  <?php
  @include '../config.php';
  if (mysqli_connect_error()) {
      echo "Failed to connect to MySQL: " .mysqli_connect_error();
      exit();
  }

  # Query the database
  $newStudents = "SELECT Id, CONCAT(FirstName,' ',LastName) as StudentName, Email, Status FROM users WHERE UserType = '1' AND Created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() ";
  $NewstudentResultTable = mysqli_query($conn, $newStudents);
  ?>
<?php if(mysqli_num_rows($NewstudentResultTable) == 0){?>
        <span class="text-danger">No results</span>
      <?php } 
        if(mysqli_num_rows($NewstudentResultTable)> 0){
        ?>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Student Name</th>
            <th scope="col">Email</th>
          </tr>
        </thead>
        <tbody>
        <?php while($studentRow = mysqli_fetch_array($NewstudentResultTable)) {
          ?>
          <tr>
            <td><?php echo $studentRow['Id'] ?></td>
            <td><?php echo $studentRow['StudentName'] ?></td>
            <td><?php echo $studentRow['Email']?></td>
          </tr>
          <?php } }?>
        </tbody>
</table>
</div>
</section>
</body>


<script>
    $(document).ready(function() {
            $('nav .logo-container ul li a.dashboard').removeClass('active');
            $('nav .logo-container ul li a.exams').removeClass('active');
            $('nav .logo-container ul li a.students').addClass('active');
            $('nav .logo-container ul li a.subjects').removeClass('active');
    })

    const studentTableTdList = document.querySelectorAll('.Allstudents table tbody tr td span');

    studentTableTdList.forEach((td) => {
         if (td.textContent === 'Offline') {
        td.style.backgroundColor = '#fbe2e5';
        td.style.color = '#e96d7f';
        td.style.border = '1px solid #e96d7f';
        }else if (td.textContent === 'Online') {
        td.style.backgroundColor = '#d5f6de';
        td.style.color = '#2ed15a';
        td.style.border = '1px solid #2ed15a';
        }
    });
    

$(document).ready(function(){
        $('#AllStudentsForm input').on('keydown', function() {
            var studentFilter = $('#AllStudentsForm input').val();
            $.ajax({
      url: '../Backend/ManageStudents/filterAllStudentsLogic.php',  
      type: 'POST',
      data: {
        studentFilter: studentFilter
      },
      success: function(data) {
        console.log(data);
        
        $('.Allstudents').html(data);
        const AllstudentTableTdList = document.querySelectorAll('.Allstudents table tbody tr td span');
        AllstudentTableTdList.forEach((td) => {
        if (td.textContent === 'Offline') {
        td.style.backgroundColor = '#fbe2e5';
        td.style.color = '#e96d7f';
        td.style.border = '1px solid #e96d7f';
        }else if (td.textContent === 'Online') {
        td.style.backgroundColor = '#d5f6de';
        td.style.color = '#2ed15a';
        td.style.border = '1px solid #2ed15a';
        }
    });
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log("Error: " + errorThrown);
        console.log("Status: " + textStatus);
        console.dir(jqXHR);
      }
    });
        } )
    } 
    )

    $(document).ready(function(){
        $('#NewStudentsForm input').on('keydown', function() {
            var studentFilter = $('#NewStudentsForm input').val();
            $.ajax({
      url: '../Backend/ManageStudents/filterNewStudentsLogic.php',  
      type: 'POST',
      data: {
        studentFilter: studentFilter
      },
      success: function(data) {
        console.log(data);
        
        $('.NewStudents').html(data);
        
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log("Error: " + errorThrown);
        console.log("Status: " + textStatus);
        console.dir(jqXHR);
      }
    });
        } )
    } 
    )



</script>
</html>