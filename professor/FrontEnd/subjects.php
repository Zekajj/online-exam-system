<?php 
   @include '../../config.php';

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
    <link rel="stylesheet" href="subjects.css">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
    #inputForm {
      display: none;
    }
  </style>
</head>
<body style="background:#f1f1f3;">
    <?php @include 'navbar.php' ?>
    <?php  require '../Backend/ManageSubjects/addSubjectLogic.php'?>

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
              <button id="openFormButton"><i class='bx bx-plus'></i>&nbsp;Create New Subject</button>
              
              
  </div>

  <div id="addNewSubjectContainer" style="display: none;">
    <form id="addNewSubjectForm" method="post">
               <input type="text" id="name" name="subjectName" placeholder="Enter subject name" required>
               <br>
   
               <button type="submit" name="addSubject">Save</button>
    </form>
  </div>


 <div class="filters">
        <div><input type="search" placeholder="Search subject" /></div>
        <div>
            <select>
                <option>All</option>
            </select>
            <button>
                Filter&nbsp;<i class="bi bi-filter"></i>
            </button>
        </div>
    </div>

  <div class="subjectTable">
    <table class="table ">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Subject Name</th>
      <th scope="col">Created at</th>
      <th scope="col">Actions</th>

    </tr>
  </thead>
  <tbody>
    <?php  
    if(mysqli_num_rows($resultSubjectTable )>0){
      while($subjectRow = mysqli_fetch_array($resultSubjectTable)){    
    ?>
    <tr>
      <td> <?php echo $subjectRow['Id']?> </td>
      <td> <?php echo $subjectRow['Name']?> </td>
      <td> <?php echo $subjectRow['Created_at']?> </td>
      <td> 
        <button class="editSubjectBtn" id="editSubjectButton"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</button>
        <button class="delete-subject delete"><i class="fa-solid fa-trash-can"></i>&nbsp;Delete</button>
      </td> 
    
    </tr>
    <?php }}?>
  </tbody>
</table>

</div>
<div id="edit-subject-form" style="display:none">
<div style="display:flex;flex-direction:row; justify-content:space-between;">
  <h2>Edit Subject</h2>
  <i class="fa-solid fa-x close-edit-subject-form" style="cursor:pointer;"></i>
  </div>
  <form id="edit-subject" method="POST">
    <input type="hidden" id="editSubjectId" name="editSubjectId">
    <label for="editSubjectName">Name:</label>
    <input type="text" id="editSubjectName" name="editSubjectName">
    <button type="submit" id="editSubjectSubmit">Save</button>
  </form>
</div>
  

  </section>
</body>




<script>


$(document).on('click', '.editSubjectBtn', function(){
    // get the row that was clicked
    var row = $(this).closest('tr');

    // extract the data from its cells
    var subjectId = row.find('td:eq(0)').text().trim();
    var subjectName = row.find('td:eq(1)').text().trim();
    var createdAt = row.find('td:eq(2)').text().trim();

    // prefill the form fields with the data
    $('#editSubjectId').val(subjectId);
    $('#editSubjectName').val(subjectName);

    // show the edit form
    $('#edit-subject-form').show();
});


$(document).on('submit', '#edit-subject', function(e) {

  var subjectId = $('#editSubjectId').val();
  var subjectName = $('#editSubjectName').val();

  $.ajax({
    url: '../Backend/ManageSubjects/subject_edit.php',
    type: 'POST',
    data: {
      editSubjectId: subjectId,
      editSubjectName: subjectName
    },
    success: function(data) {
      console.log(data);
      // hide the form and reload the subject table
      $('#edit-subject-form').hide();
      location.reload();
    },
    error: function(xhr, status, error) {
      console.error(error);
    }
  });
});


//deletesubject
$(document).on('click', '.subjectTable table tbody tr td .delete-subject', function(){
    var subjectId = $(this).closest('tr').find('td:eq(0)').text().trim(); 
    console.log('subjectId', subjectId);

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({  
                url: "../Backend/ManageSubjects/subject_delete.php",
                type: "POST",
                data: { subjectId: subjectId },
                success: function(data) {
                    console.log(data);
                    Swal.fire(
                        'Subject deleted successfully!',
                        '',
                        'success'
                    )
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
})


    $(document).ready(function() {
            $('nav .logo-container ul li a.dashboard').removeClass('active');
            $('nav .logo-container ul li a.exams').removeClass('active');
            $('nav .logo-container ul li a.subjects').addClass('active');
            $('nav .logo-container ul li a.students').removeClass('active');
    })
    document.getElementById("openFormButton").addEventListener("click", function() {
      if(document.getElementById("addNewSubjectContainer").style.display == "none"){
          document.getElementById("addNewSubjectContainer").style.display = "flex";
        }
        else{
          document.getElementById("addNewSubjectContainer").style.display = "none";
        }
    });
    $(document).on('click', '#editSubjectButton', function(){
        $('#edit-subject-form').show();
    });

    $(document).on('click', '.close-edit-subject-form', function(){
        $('#edit-subject-form').hide();
    })


</script>
</html>