
<?php 
    @include '../../config.php';

    session_start();

    if(!isset($_SESSION['professorUsername'])){
        header('Location:login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exam</title>
    <link rel="stylesheet" href="newExam.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body style="background:#f1f1f3;">
    <?php require '../Backend/ManageExams/NewExamLogic.php' ?>
    <?php @include 'navbar.php' ?>


<div class="newExamContainer">

<!--The form for creating a new exam-->
    <div class="create-exam-container">
            <form action="" method="post">
                <input type="text" id="exam-title" required name="exam-title" placeholder="Enter exam title">
                    <select id="subject" name="subject" required>
                        <option value="0" selected disabled>Select Subject</option>
                        <?php $subjectTable = "SELECT Id, Name from subject";
                                $resultSubjectTable = mysqli_query($conn,$subjectTable);
                                if(mysqli_num_rows($resultSubjectTable) > 0){
                                    while($subjectRow = mysqli_fetch_array($resultSubjectTable)){
                                ?>
                                <option value="<?php echo $subjectRow['Id']?>"><?php echo $subjectRow['Name']?></option>
                                <?php } }?>
                    </select>

            <h5 style="margin-top: 100px;border-bottom:1px solid lightgray;width:90%;">Exam Settings</h5>        

            <label for="start-date">Start Date:</label>
            <input type="datetime-local" id="start-date" name="startDate" required>

            <label for="duration">Duration (minutes):</label>
            <input type="number" id="duration" name="duration" required>
            <button id="create-exam" name="createExam" type="submit">Create Exam</button>
            </form>
        </div>
    <div class="main-content">

    <!--The form for getting the exams records between to dates(from > to)-->
        <form action="" id="betweenDatesForm" method="post">
                <div style="display:flex; flex-direction:column;">
                    <label for="">From:</label>
                    <input type="date" name="From" value="<?php echo date('Y-m-d'); ?>" >
                </div>
                <div style="display:flex; flex-direction:column;">
                    <label for="">To:</label>
                    <input type="date" name="To" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </form>  

        <!--The exam table-->    
        <div class="exam-table">
                                     
                <?php
                    if(mysqli_num_rows($resultExamTable) == 0){
                ?>
                        <div style="margin-bottom:10px;"><span style="font-size:1.5rem; border-bottom:3px solid #b9b1e5;">Exams</span></div>
                        <span class="text-danger">No exams for today</span>
                        
                <?php 
                    }
                    if(mysqli_num_rows($resultExamTable)> 0){
                    ?>
                <div style="margin-bottom:10px;"><span style="font-size:1.5rem; border-bottom:3px solid #b9b1e5;">Exams</span></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Id</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Professor</th>
                            <th scope="col">Title</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>

                        </tr>
                    </thead>
                    <tbody id="exam-table-body">
                         <?php while($examRow = mysqli_fetch_array($resultExamTable)) {
                        ?>
                        <tr data-id="<?php echo $examRow['Id'] ?>">
                            <td><input type="checkbox" class="check-exam-row form-check-input"></td>
                            <td><?php echo $examRow['Id'] ?></td>
                            <td><?php echo $examRow['SubjectName'] ?></td>
                            <td><?php echo $examRow['Professor'] ?></td>
                            <td><?php echo $examRow['Title'] ?></td>
                            <td><?php echo $examRow['StartDate'] ?></td>
                            <td><?php echo $examRow['Duration'] ?> Min</td>

                            <td><?php if($examRow['Status'] == '0'){
                                echo '<span>Inactive</span>';
                                } else if($examRow['Status'] == '1'){
                                    echo '<span>Active</span>';
                                } else {
                                    echo '<span>New</span>';
                            } ?> </td>
                            <td>
                                <button id="updateExam"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</button>
                                <button class="delete examTableActions"><i class="fa-solid fa-trash-can"></i>&nbsp;Delete</button> 
                            </td>
                        </tr>
                        <?php } }?>
                    </tbody>
            </table>
        </div>

        <!--The form for updating the exam-->
        <div class="update-exam-form">
                <form id="updateExam-form" method="POST">
                    <div class="close-button">
                        <i class="fa-solid fa-x"></i>
                    </div>
                    <input type="number" hidden id="examId" name="examId">

                    <label for="examTitle" >Exam Title:</label>
                    <input type="text" id="examTitle" name="examTitle" required>

                    <label for="Subject" >Subject:</label>
                    <select id="Subject" name="Subject" required>
                        <option value="0" selected disabled>Select Subject</option>
                        <?php $subjectTable = "SELECT Id, Name from subject";
                                $resultSubjectTable = mysqli_query($conn,$subjectTable);
                                if(mysqli_num_rows($resultSubjectTable) > 0){
                                    while($subjectRow = mysqli_fetch_array($resultSubjectTable)){
                                ?>
                                <option value="<?php echo $subjectRow['Id']?>"><?php echo $subjectRow['Name']?></option>
                                <?php } }?>
                    </select>

                    <label for="StartDate">Start Date:</label>
                    <input type="datetime-local" id="StartDate" name="StartDate" required>

                    <label for="Duration">Duration:</label>
                    <input type="number" id="Duration" name="Duration"  required>

                    <div class="save-button">
                            <button name="update-exam" id="update-exam-btn" type="submit">Save</button>
                    </div>
                </form>
            </div>

        <div class="exam-title">
            <!--The button that shows the question form -->
            <button id="add-question"><i class='bx bx-plus'></i>&nbsp;Add Question</button>
               
            <!--The form for inserting a question-->
            <div id="add-question-form">
                <form id="question-form" method="post">
                    <div class="close-btn">
                        <i class="fa-solid fa-x"></i>
                    </div>
                    <input type="text" hidden name="examIdForAddQuestion" id="examIdForAddQuestion">
                    <h5 style="font-weight: 600;margin-bottom: 10px;" id="examName" name="examName"></h5>
                    <label for="question" >Question:</label>
                    <textarea type="text" id="question" name="question" required rows="4"></textarea>
                    <div class="form-row">
                        <div>
                            <label for="points-input">Points:</label>
                            <input type="number" id="points-input" min="0" name="points" required>
                        </div>
                    <div class="save-button">
                            <button name="saveQuestion" id="saveQuestion" type="submit">Save</button>
                    </div>
                    </div>
                </form>
            </div>
            <!---->

            <!--Question table-->
            <div class="question-table">
                
            </div>
            <!---->



            <!--Answer Table-->
            <div class="answer-table">
                
            </div>
            <!---->

               
            <div id="add-answer-form">
                <form id="answer-form" method="post">
                    <div class="close-answer-form-btn">
                        <i class="fa-solid fa-x" style="cursor:pointer;"></i>
                    </div>
                    <input type="text" hidden name="questionIdForAddAnswer" required id="questionIdForAddAnswer">
                    <h5 style="font-weight: 600;margin-bottom: 10px;" id="questionName" name="questionName"></h5>
                    <label for="answer" >Answer:</label>
                    <textarea type="text" id="answer" name="answer" required rows="4"></textarea>
                    <span class="text-danger" id="moreThanOneCorrectAnswerError"></span>
                    <div class="form-row">
                        <div style="display:flex;flex-direction:row;align-items:center;">
                            <input style="margin:0;" type="checkbox" id="answerStatus" name="answerStatus" class="form-check-input">
                            <label for="answerStatus">Correct answer</label>
                        </div>
                    <div class="save-button">
                            <button name="saveAnswer" id="saveAnswer" type="submit">Save</button>
                    </div>
                    </div>
                </form>
            </div>

            <!-- Update answer -->
            <div id="edit-answer-form">
                <form id="editAnswerForm" method="post">
                    <div class="close-answer-form-btn">
                        <i class="fa-solid fa-x" style="cursor:pointer;"></i>
                    </div>
                    <input type="text" hidden name="questionIdForEditAnswer" required id="questionIdForEditAnswer">
                    <input type="hidden" name="answerIdForEditAnswer" required id="answerIdForEditAnswer">
                    <h5 style="font-weight: 600;margin-bottom: 10px;" id="QuestionName" name="QuestionName"></h5>
                    <label for="editAnswer" >Answer:</label>
                    <textarea type="text" id="editAnswer" name="editAnswer" required rows="4"></textarea>
                    <span class="text-danger" id="moreThanOneCorrectAnswerError"></span>
                    <div class="form-row">
                        <div style="display:flex;flex-direction:row;align-items:center;">
                            <input style="margin:0;" type="checkbox" id="editAnswerStatus" name="editAnswerStatus" class="form-check-input">
                            <label for="editAnswerStatus">Correct answer</label>
                        </div>
                    <div class="save-button">
                            <button name="saveEditAnswer" id="saveEditAnswer" type="submit">Save</button>
                    </div>
                    </div>
                </form>
            </div>

             <!-- Update question -->
            <div class="update-question-form">
                <form id="update-question" method="post">
                    <div class="close-btn">
                        <i class="fa-solid fa-x"></i>
                    </div>
                    <input type="hidden" id="questionId" name="questionId">
                    <h5 style="font-weight: 600;margin-bottom: 10px;" id="ExamName" name="ExamName"></h5>
                    <label for="update-question-title" >Question:</label>
                    <textarea type="text" id="update-question-title" name="update-question-title" required rows="4"></textarea>
                    <div class="form-row">
                        <div>
                            <label for="questionPoints">Points:</label>
                            <input type="number" id="questionPoints" min="0" name="questionPoints" required>
                        </div>
                    <div class="save-button">
                            <button name="update-question" id="update-question-btn" type="submit">Save</button>
                    </div>
                    </div>
                </form>
            </div>
                
        </div>
    </div>

    <!--After completing the exam, inserting the questions and the answers we click this button to complete the exam.
    After clicking this button the exam that was completed will update the status to Active-->
    <div class="completeExamContainer">
        <form action="" id="completeExamForm"  method="post">
            <input type="text" hidden name="examIdToCompleteExam" id="examIdToCompleteExam">
            <button class="completeExam" name="completeExam">Complete Exam &nbsp;<i class="fa-solid fa-check"></i></button>
        </form>
    </div>
    </div>


</body>

<script>
    $(document).ready(function() {
        $('nav .logo-container ul li a.dashboard').removeClass('active');
        $('nav .logo-container ul li a.exams').addClass('active');
        $('nav .logo-container ul li a.subjects').removeClass('active');
        $('nav .logo-container ul li a.students').removeClass('active');
        $('nav .logo-container ul li a.results').removeClass('active');
    })


    const addQuestionButton = document.getElementById('add-question');
    const addQuestionPopup = document.getElementById('add-question-form');
    const closeBtn = document.querySelector('.close-btn');

    addQuestionButton.addEventListener('click', () => {
        addQuestionPopup.style.display = 'block';
    });

    closeBtn.addEventListener('click', () => {
        addQuestionPopup.style.display = 'none';
    });



    /*The code that prevents more than one checkbox being checked*/
    /*const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', () => {
    // If this checkbox is checked, disable all the other checkboxes
    if (checkbox.checked) {
      checkboxes.forEach((otherCheckbox) => {
        if (otherCheckbox !== checkbox) {
          otherCheckbox.disabled = true;
        }
      });
    } else {
      // If this checkbox is unchecked, enable all the checkboxes
      checkboxes.forEach((otherCheckbox) => {
        otherCheckbox.disabled = false;
      });
    }
    });
    });*/


//The js code to getThe exam row and fill the update exam form with that row data
$(document).on('click', '#updateExam', function(){
    // get the values from the table row
            var examId = $(this).closest('tr').find('td:eq(1)').text().trim();
            var subjectId = $(this).closest('tr').find('td:eq(2)').text().trim();
            var examTitle = $(this).closest('tr').find('td:eq(4)').text().trim();
            var startDate = $(this).closest('tr').find('td:eq(5)').text().trim();
            var duration = $(this).closest('tr').find('td:eq(6)').text().trim().replace(" Min", "");
        
            // set the values to the update exam form inputs
            $('#examId').val(examId);
            $('#examTitle').val(examTitle);
            $('#Subject option').filter(function() {
                return $(this).text() === subjectId;
            }).prop('selected', true);  
            $('#StartDate').val(startDate);
            $('#Duration').val(duration);
        
        
            $('.update-exam-form').show();
            });

            $(document).on('click', '.close-button', function(){
                $('.update-exam-form').hide();
            })

            /*Update exam with ajax*/

            $(document).ready(function() {
            $('#updateExam-form').on('submit', function(event) {
                event.preventDefault(); // Prevent form submission
                var examId = $('#examId').val();
                var examTitle = $('#examTitle').val();
                var subjectId = $('#Subject option:selected').val();
                var startDate = $('#StartDate').val();
                var duration = $('#Duration').val();

                $.ajax({
                type: 'POST',
                url: '../Backend/ManageExams/EditExamLogic.php',
                data: {
                    'examId': examId,
                    'examTitle': examTitle,
                    'Subject': subjectId,
                    'StartDate': startDate,
                    'Duration': duration,   
                    'update-exam': true
                },
                success: function(response) {
            if (response == 'success') {
                // get the values from the form
                var examTitle = $('#examTitle').val();
                var subjectName = $('#Subject option:selected').text();
                var startDate = $('#StartDate').val();
                var seconds = new Date(startDate).getSeconds(); // get the seconds value from the date
                startDate = startDate.replace('T', ' ') + ':' + seconds + seconds; // concatenate the seconds value to the date string // set the text of the table cell to the updated date string

                // append seconds to ISO string

                var duration = $('#Duration').val();
                var status = $('#Status').val();

                // update the table row with the new values
                var $row = $('tr[data-id="' + examId + '"]');
                $row.find('td:eq(4)').text(examTitle);
                $row.find('td:eq(2)').text(subjectName);
                $row.find('td:eq(5)').text(startDate);
                $row.find('td:eq(6)').text(duration + ' Min');
                $row.find('td:eq(7) span').text(status);

                // hide the update form and show success message
                $('.update-exam-form').hide();
                Swal.fire({
                    title: 'Exam updated successfully',
                    icon: 'success'
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred while updating the exam.',
                    icon: 'error'
                });
            }
        }
        });
    });
});



/*Display the question table*/
function QuestionTable(examId){
    $.ajax({  
       url: "../Backend/ManageQuestions/QuestionTableLogic.php",
        type: "POST",
        data: { examIdForAddQuestion: examId },
        success: function(data) {
            console.log(data);
            $('.question-table').html(data);
        },
        error: function(xhr, status, error) {
        console.error(error);
        }
});   
}


/*Display the answer table*/
function AnswerTable(questionId){
    $.ajax({  
        url: "../Backend/ManageAnswers/AnswerTableLogic.php",
        type: "POST",
        data: { questionIdForAddAnswer: questionId },
        success: function(data) {
            console.log(data);
            $('.answer-table').html(data);
            AnswerTableTdList();
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
        });
}
              


/*Display exams between dates*/
function ExamBetweenDates(){
    var fromDate = $('input[name="From"]').val();
    var toDate = $('input[name="To"]').val();   

    $.ajax({
      url: '../Backend/ManageExams/ExamBetweenDates.php',  
      type: 'POST',
      data: {
        'From': fromDate,
        'To': toDate
      },
      success: function(data) {
        console.log(data);
        $('.exam-table').html(data);
        const examTableTdList = document.querySelectorAll('.exam-table table tbody tr td span');  
        examTableTdList.forEach((td) => {
            if (td.textContent === 'New') {
            td.style.backgroundColor = '#ddf1fb';
            td.style.color = '#53b7ec';
            td.style.border = '1px solid #53b7ec';
            } else if (td.textContent === 'Inactive') {
            td.style.backgroundColor = '#fbe2e5';
            td.style.color = '#e96d7f';
            td.style.border = '1px solid #e96d7f';
            }else if (td.textContent === 'Active') {
            td.style.backgroundColor = '#e9f5ef';
            td.style.color = '#93ccad';
            td.style.border = '1px solid #93ccad';
            }
        });
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log("Error: " + errorThrown);
        console.log("Status: " + textStatus);
        console.dir(jqXHR);
      }
    });
}



/*Display exam between dates when the inputs "from" and "to" are changed*/
$(document).ready(function() {
    $('#betweenDatesForm input').change(function() {
    var fromDate = $('input[name="From"]').val();
    var toDate = $('input[name="To"]').val();   

    $.ajax({
      url: '../Backend/ManageExams/ExamBetweenDates.php',  
      type: 'POST',
      data: {
        'From': fromDate,
        'To': toDate
      },
      success: function(data) {
        console.log(data);
        $('.exam-table').html(data);
        const examTableTdList = document.querySelectorAll('.exam-table table tbody tr td span');  
        examTableTdList.forEach((td) => {
            if (td.textContent === 'New') {
            td.style.backgroundColor = '#ddf1fb';
            td.style.color = '#53b7ec';
            td.style.border = '1px solid #53b7ec';
            } else if (td.textContent === 'Inactive') {
            td.style.backgroundColor = '#fbe2e5';
            td.style.color = '#e96d7f';
            td.style.border = '1px solid #e96d7f';
            }else if (td.textContent === 'Active') {
            td.style.backgroundColor = '#e9f5ef';
            td.style.color = '#93ccad';
            td.style.border = '1px solid #93ccad';
            }
        });
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log("Error: " + errorThrown);
        console.log("Status: " + textStatus);
        console.dir(jqXHR);
      }
    });
  });
});



//On exam row check display all the questions for that exam
$(document).on('click', '.check-exam-row', function(){
    // get the values from the table row
    if($(this).is(':checked')) {
        var examId = $(this).closest('tr').find('td:eq(1)').text().trim();
        var examName = $(this).closest('tr').find('td:eq(4)').text().trim();
        $('#examIdForAddQuestion').val(examId);
        $('#examIdToCompleteExam').val(examId);
        $('#examName').html(examName);
        console.log(examId);
         /*Question for selected exam*/
        $.ajax({  
        url: "../Backend/ManageQuestions/QuestionTableLogic.php",
        type: "POST",
        data: { examIdForAddQuestion: examId },
        success: function(data) {
            console.log(data);
            $('.question-table').html(data);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
        });

        $(this).closest('tr').addClass('checked-exam-row');
    } else {
        $('#examIdForAddQuestion').val("");
        $('#examName').html("");
        $('.question-table').html("");
        $('.answer-table').html("");
        $(this).closest('tr').removeClass('checked-exam-row');
    }
});



//Design for the span(Status: New, Active,Inactive) in td in the exam table
const examTableTdList = document.querySelectorAll('.exam-table table tbody tr td span');  

examTableTdList.forEach((td) => {
    if (td.textContent === 'New') {
    td.style.backgroundColor = '#ddf1fb';
    td.style.color = '#53b7ec';
    td.style.border = '1px solid #53b7ec';
    } else if (td.textContent === 'Inactive') {
    td.style.backgroundColor = '#fbe2e5';
    td.style.color = '#e96d7f';
    td.style.border = '1px solid #e96d7f';
    }else if (td.textContent === 'Active') {
    td.style.backgroundColor = '#e9f5ef';
    td.style.color = '#93ccad';
    td.style.border = '1px solid #93ccad';
    }
});


/*Adding a new question with ajax. To add the new question we need the exam id which is fetched by checking
the exam row that we want to insert the question to*/
$(document).ready(function(){
    $('#question-form').on('submit', function(event){
        event.preventDefault();
        var examId = $('#examIdForAddQuestion').val();
        var question = $('#question').val();
        var points = $('#points-input').val();

        $.ajax({  
            url: "../Backend/ManageQuestions/NewQuestionLogic.php",
            type: "POST",
            data: { 
                question: question,
                points: points,
                examIdForAddQuestion: examId,   
                saveQuestion: true    
            },
            success: function(data) {
                console.log(data);
                Swal.fire({
                    title: 'Question added successfully',
                    icon: 'success'
                });
                $('#add-question-form').hide();
                $('#examForAddQuestion').val('');
                $('#points-input').val('');
                $('#question').val('');
                $.ajax({  
                url: "../Backend/ManageQuestions/QuestionTableLogic.php",
                type: "POST",
                data: { examIdForAddQuestion: examId },
                success: function(data) {
                    console.log(data);
                    $('.question-table').html(data);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
                });

            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});



// Update question
$(document).on('click', '#updateQuestion', function(){
    // get the row that was clicked
    var row = $(this).closest('tr');

    // extract the data from its cells
    var questionId = row.data('id');
    var ExamName = row.find('td:eq(2)').text().trim();
    var questionTitle = row.find('td:eq(5)').text().trim();
    var questionPoints = row.find('td:eq(6)').text().trim();

    // prefill the form fields with the data
    $('#questionId').val(questionId);
    $('#ExamName').html(ExamName);
    $('#update-question-title').val(questionTitle);
    $('#questionPoints').val(questionPoints);
  
  
    $('.update-question-form').show();
    });

    $(document).on('click', '.close-btn', function(){
        $('.update-question-form').hide();
    })

    // Update with ajax
    // Attach submit event to update form
    $(document).on('submit', '#update-question', function(event){
    event.preventDefault(); // Prevent default form submission behavior

    // Collect the updated data from the form fields
    var questionId = $('#questionId').val();
    var questionTitle = $('#update-question-title').val();
    var questionPoints = $('#questionPoints').val();

    // Send an AJAX request to the server with the updated data
    $.ajax({
        url: '../Backend/ManageQuestions/EditQuestionLogic.php',
        type: 'POST',
        data: {
            'questionId': questionId,
            'update-question-title': questionTitle,
            'questionPoints': questionPoints,
            'update-question': true
        },
        success: function(response) {
            // Handle the response from the server
            if(response == 'success') {
                // Update the question table with the new data
                var row = $('#question-table-body').find('tr[data-id="' + questionId + '"]');
                row.find('td:eq(5)').text(questionTitle);
                row.find('td:eq(6)').text(questionPoints);

                // Hide the update form
                $('.update-question-form').hide();
                Swal.fire({
                title: 'Question updated successfully',
                icon: 'success'
        });
            } else {
                Swal.fire({
                title: 'Error',
                text: 'An error occurred while updating the question.',
                icon: 'error'
        });
            }
        }
    });
});


//Showing the answer form and fetching the question title and id from that row
$(document).on('click', '#addAnswerBtn', function(){
    var questionId = $(this).closest('tr').find('td:eq(1)').text().trim();
    var questionName = $(this).closest('tr').find('td:eq(5)').text().trim();
    $('#questionIdForAddAnswer').val(questionId);
    $('#questionName').html(questionName);   
    $('#add-answer-form').show();
})


//Closing the answer form
$(document).on('click', '.close-answer-form-btn', function(){
    $('#add-answer-form').hide();
})


//Design for the td span in asnwer table for Status: Correct, Incorrect 
function AnswerTableTdList(){
   const answerTableTdList = document.querySelectorAll('.answer-table table tbody tr td span');
  
  answerTableTdList.forEach((td) => {
        if(td.textContent === 'Incorrect') {
          td.style.backgroundColor = '#fbe2e5';
          td.style.color = '#e96d7f';
          td.style.border = '1px solid #e96d7f';
          }else if (td.textContent === 'Correct') {
          td.style.backgroundColor = '#e9f5ef';
          td.style.color = '#93ccad';
          td.style.border = '1px solid #93ccad';
          }
      });
  }






  
//Inserting the answer into the answer table
$(document).ready(function(){
    $('#answer-form').on('submit', function(event){
        event.preventDefault();
        var questionId = $('#questionIdForAddAnswer').val();
        var answer = $('#answer').val();
        var answerStatus = '0';
        if($('#answerStatus').prop('checked')){
            answerStatus = '1';
        }
        else{
            answerStatus = '0';
        }

        $.ajax({  
            url: "../Backend/ManageAnswers/NewAnswerLogic.php",
            type: "POST",
            data: { 
                answer: answer,
                answerStatus: answerStatus,
                questionIdForAddAnswer: questionId,   
                saveAnswer: true    
            },
            success: function(data) {
                console.log(data);
                if(data.trim() === 'There can only be one correct answer per question') {
                    $('#moreThanOneCorrectAnswerError').html(data);
                    $('#answerStatus').prop('checked',false);
                } 
                else {
                    $('#moreThanOneCorrectAnswerError').html("");
                    $('#add-answer-form').hide();
                    $('#questionIdForAddAnswer').val("");
                    $('#answerStatus').prop('checked', false);
                    $('#answer').val("");

                    // Call the AnswerTableLogic.php to update the answer table
                    $.ajax({  
                        url: "../Backend/ManageAnswers/AnswerTableLogic.php",
                        type: "POST",
                        data: { questionIdForAddAnswer: questionId },
                        success: function(data) {
                            console.log(data);
                            $('.answer-table').html(data);
                            AnswerTableTdList();
                            // Display success message after answer is added and table is updated
                            Swal.fire({
                                title: 'Answer added successfully',
                                icon: 'success'
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});

//Edit answer
$(document).on('click', '#editAnswerBtn', function(){
    // get the row that was clicked
    var row = $(this).closest('tr');

    // extract the data from its cells
    var answerId = row.data('id');
    var QuestionId = row.find('td:eq(2)').text().trim();
    var QuestionName = row.find('td:eq(3)').text().trim();
    var answer = row.find('td:eq(5)').text().trim();
    var status = row.find('td:eq(6) span').text().trim();

    // prefill the form fields with the data
    $('#questionIdForEditAnswer').val(QuestionId);
    $('#QuestionName').html(QuestionName);   
    $('#answerIdForEditAnswer').val(answerId);
    $('#editAnswer').val(answer);
    $('#editAnswerStatus').prop('checked', status === 'Correct');
  
    $('#edit-answer-form').show();
})

$(document).on('click', '.close-answer-form-btn', function(){
    $('#edit-answer-form').hide();
})

// Update with ajax
    // Attach submit event to update form
    $(document).on('submit', '#editAnswerForm', function(event){
    event.preventDefault(); // Prevent default form submission behavior

    // Collect the updated data from the form fields
    var answerId = $('#answerIdForEditAnswer').val();
    var answer = $('#editAnswer').val();
    if($('#editAnswerStatus').prop('checked')){
            status = '1';
        }
        else{
            status = '0';
        }

    // Send an AJAX request to the server with the updated data
    $.ajax({
        url: '../Backend/ManageAnswers/EditAnswerLogic.php',
        type: 'POST',
        data: {
            'answerIdForEditAnswer': answerId,
            'editAnswer': answer,
            'editAnswerStatus': status,
            'saveEditAnswer': true
        },
        success: function(response) {
            // Handle the response from the server
            if(response == 'success') {
                // Update the question table with the new data
                var row = $('#answer-table-body').find('tr[data-id="' + answerId + '"]');
                row.find('td:eq(5)').text(answer);
                if(status === '1') {
                row.find('td:eq(6) span').text('Correct');
                AnswerTableTdList();
                } else {
                row.find('td:eq(6) span').text('Incorrect');
                AnswerTableTdList();
                }

                // Hide the update form
                $('#edit-answer-form').hide();
                Swal.fire({
                title: 'Answer updated successfully',
                icon: 'success'
        });
            } else {
                Swal.fire({
                title: 'Error',
                text: 'An error occurred while updating the answer.',
                icon: 'error'
        });
            }
        }
    });
});



//On question row check display the answer table for that question
$(document).on('click', '.check-question-row', function(){
    // get the values from the table row
    if($(this).is(':checked')) {
        var questionId = $(this).closest('tr').find('td:eq(1)').text().trim();
        console.log(examId);
         /*Question for selected exam*/
        $.ajax({  
        url: "../Backend/ManageAnswers/AnswerTableLogic.php",
        type: "POST",
        data: { questionIdForAddAnswer: questionId },
        success: function(data) {
            console.log(data);
            $('.answer-table').html(data);
            AnswerTableTdList();
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
        });

        $(this).closest('tr').addClass('checked-exam-row');
    } else {
        $('.answer-table').html("");
        $(this).closest('tr').removeClass('checked-exam-row');
    }
});



/*Delete the question from table along with all of the questions connected to it*/
$(document).on('click', '.question-table table tbody tr td .delete', function(){
    var questionId = $(this).closest('tr').find('td:eq(1)').text().trim(); 
    var examId = $('#examIdForAddQuestion').val();
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
                url: "../Backend/ManageQuestions/DeleteQuestionLogic.php",
                type: "POST",
                data: { questionId: questionId },
                success: function(data) {
                    console.log(data);
                    Swal.fire(
                        'Question deleted successfully!',
                        '',
                        'success'
                    )
                    QuestionTable(examId);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
});



/*Delete the exam table along with all of its content*/
$(document).on('click', '.exam-table table tbody tr td .delete', function(){
    var examId = $(this).closest('tr').find('td:eq(1)').text().trim(); 
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
                url: "../Backend/ManageExams/DeleteExamLogic.php",
                type: "POST",
                data: { examId: examId },
                success: function(data) {
                    console.log(data);
                    Swal.fire(
                        'Exam deleted successfully!',
                        '',
                        'success'
                    )
                    QuestionTable();
                    ExamBetweenDates();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
});



/*Delete answer*/
$(document).on('click', '.answer-table table tbody tr td .delete', function(){
    var answerId = $(this).closest('tr').find('td:eq(1)').text().trim(); 
    var questionId = $(this).closest('tr').find('td:eq(2)').text().trim();
    console.log('AnswerId', answerId);

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
                url: "../Backend/ManageAnswers/DeleteAnswerLogic.php",
                type: "POST",
                data: { answerId: answerId },
                success: function(data) {
                    console.log(data);
                    Swal.fire(
                        'Answer deleted successfully!',
                        '',
                        'success'
                    )
                    AnswerTable(questionId);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

})



$(document).ready(function(){
    $('#completeExamForm').on('submit', function(event){
        event.preventDefault();
        var examId = $('#examIdToCompleteExam').val();
        $.ajax({  
                url: "../Backend/ManageExams/completeExamLogic.php",
                type: "POST",
                data: { examIdToCompleteExam: examId },
                success: function(data) {
                    console.log(data);
                    Swal.fire(
                        'Exam completed!',
                        '',
                        'success'
                    )
                    ExamBetweenDates();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
    })
})








</script>

</html>