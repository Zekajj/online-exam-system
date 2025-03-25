<?php 
    @include '../../../config.php';

    $questionIdForAddAnswer = isset($_POST['questionIdForAddAnswer']) ? $_POST['questionIdForAddAnswer'] : '';

    $sql = "Select a.Id,q.Id as QuestionId, q.Title as Question, Concat(u.FirstName, ' ', u.LastName) as Professor, a.Title as Answer, a.Status from answers a
     join questions q on a.QuestionId = q.Id join users u on a.Professor = u.Id
     where q.Id = '{$questionIdForAddAnswer}'";

     $resultQuestionTable = mysqli_query($conn,$sql); 

     // Generate HTML table rows from query results
     $tableRows = '';
 
     if(mysqli_num_rows($resultQuestionTable) == 0){
         echo '<div style="margin-bottom:10px;"><span style="font-size:1.5rem; border-bottom:3px solid #b9b1e5;">Answers</span></div>';
         echo '<span class="text-danger">No answers for this question</span>';
     }
     else{
     while($row = mysqli_fetch_array($resultQuestionTable)) {
         $tableRows .= '<tr data-id="' . $row['Id'] . '">';
         $tableRows .= '<td><input type="checkbox" class="check-answer-row form-check-input"></td>';
         $tableRows .= '<td>' . $row['Id'] . '</td>';
         $tableRows .= '<td hidden>' . $row['QuestionId'] . '</td>';
         $tableRows .= '<td>' . $row['Question'] . '</td>';
         $tableRows .= '<td>' . $row['Professor'] . '</td>';
         $tableRows .= '<td>' . $row['Answer'] . '</td>';
         $tableRows .= '<td><span>'; 
            if ($row['Status'] == '1') {
                $tableRows .= 'Correct';
            } else {
                $tableRows .= 'Incorrect';
            }
        $tableRows .= '</span></td>';

         $tableRows .= '<td style="display:flex;align-items:center;gap:5px;">
         <button id="editAnswerBtn" name="editAnswerBtn" class="answerTableActions" style="display:flex; align-items:center;"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</button>
         <button class="delete answerTableActions"><i class="fa-solid fa-trash-can"></i>&nbsp;Delete</button>
          </td>';
         $tableRows .= '</tr>';
     }
 
     // Generate HTML table
     $table = '<table>';
     $table .= '<thead>';
     $table .= '<tr>';
     $table .= '<th></th>';
     $table .= '<th>Id</th>';
     $table .= '<th>Question</th>';
     $table .= '<th>Professor</th>';
     $table .= '<th>Answer</th>';
     $table .= '<th>Status</th>';
     $table .= '<th>Actions</th>';
     $table .= '</tr>';
     $table .= '</thead>';
     $table .= '<tbody id="answer-table-body">';
     $table .= $tableRows;
     $table .= '</tbody>';
     $table .= '</table>';
 
         echo '<div><span style="font-size:1.5rem; border-bottom:3px solid #b9b1e5;">Answers</span></div>';
         echo $table;
     }

?>