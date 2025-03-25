<?php 
    @include '../../../config.php';

    $examIdForQuestionTable = isset($_POST['examIdForAddQuestion']) ? $_POST['examIdForAddQuestion'] : '';

    $sql = "SELECT q.Id, e.Title as Exam, s.Name as Subject, CONCAT(u.FirstName, ' ', u.LastName) as Professor, q.Title, q.Points
     from questions q join exam e on q.ExamId = e.Id join subject s on q.Subject = s.Id join users u on q.Professor = u.Id
     where e.Id = '{$examIdForQuestionTable}'";

     $resultQuestionTable = mysqli_query($conn,$sql); 

     // Generate HTML table rows from query results
     $tableRows = '';
 
     if(mysqli_num_rows($resultQuestionTable) == 0){
         echo '<div style="margin-bottom:10px;"><span style="font-size:1.5rem; border-bottom:3px solid #b9b1e5;">Question</span></div>';
         echo '<span class="text-danger">No questions for this exam</span>';
     }
     else{
     while($row = mysqli_fetch_array($resultQuestionTable)) {
         $tableRows .= '<tr data-id="' . $row['Id'] . '">';
         $tableRows .= '<td><input type="checkbox" class="check-question-row form-check-input"></td>';
         $tableRows .= '<td>' . $row['Id'] . '</td>';
         $tableRows .= '<td>' . $row['Exam'] . '</td>';
         $tableRows .= '<td>' . $row['Subject'] . '</td>';
         $tableRows .= '<td>' . $row['Professor'] . '</td>';
         $tableRows .= '<td>' . $row['Title'] . '</td>';
         $tableRows .= '<td>' . $row['Points'] .'</td>';
         $tableRows .= '<td style="display:flex;align-items:center;gap:5px;">
         <button id="addAnswerBtn" name="addAnswerBtn" class="questionTableActions" style="display:flex; align-items:center;"><i class="bx bx-plus"></i>&nbsp;Add Answer</button>
         <button id="updateQuestion" class="questionTableActions" ><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</button>
         <button class="delete questionTableActions"><i class="fa-solid fa-trash-can"></i>&nbsp;Delete</button>   
                        </td>';
         $tableRows .= '</tr>';
     }
 
     // Generate HTML table
     $table = '<table>';
     $table .= '<thead>';
     $table .= '<tr>';
     $table .= '<th></th>';
     $table .= '<th>Id</th>';
     $table .= '<th>Exam</th>';
     $table .= '<th>Subject</th>';
     $table .= '<th>Professor</th>';
     $table .= '<th>Title</th>';
     $table .= '<th>Points</th>';
     $table .= '<th>Actions</th>';
     $table .= '</tr>';
     $table .= '</thead>';
     $table .= '<tbody id="question-table-body">';
     $table .= $tableRows;
     $table .= '</tbody>';
     $table .= '</table>';
 
         echo '<div><span style="font-size:1.5rem; border-bottom:3px solid #b9b1e5;">Questions</span></div>';
         echo $table;
     }

?>