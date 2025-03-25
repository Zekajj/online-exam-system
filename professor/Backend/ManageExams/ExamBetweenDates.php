<?php 
    @include '../../../config.php';

    $fromDate = isset($_POST['From']) ? date('Y-m-d', strtotime($_POST['From'])) :date('Y-m-d', strtotime($_POST['From']));
    $toDate = isset($_POST['To'])? date('Y-m-d', strtotime($_POST['To'])): date('Y-m-d', strtotime($_POST['To']));

    $examTable = "SELECT e.Id, s.Name as SubjectName, CONCAT(u.FirstName, ' ', u.LastName) as Professor,  e.Title, e.StartDate, e.Duration, e.Status 
    FROM exam e join users u on e.Professor = u.Id 
    join subject s on e.Subject = s.Id where DATE(e.Created_at) >= '$fromDate' and DATE(e.Created_at) <= '$toDate'";

    $resultExamTable = mysqli_query($conn,$examTable); 

    // Generate HTML table rows from query results
    $tableRows = '';

    if(mysqli_num_rows($resultExamTable) == 0){
        echo '<div style="margin-bottom:10px;"><span style="font-size:1.5rem; border-bottom:3px solid #b9b1e5;">Exams</span></div>';
        echo '<span class="text-danger">No exams for today</span>';
    }
    else{
    while($row = mysqli_fetch_array($resultExamTable)) {
        $tableRows .= '<tr data-id="' . $row['Id'] . '">';
        $tableRows .= '<td><input type="checkbox" class="check-exam-row form-check-input"></td>';
        $tableRows .= '<td>' . $row['Id'] . '</td>';
        $tableRows .= '<td>' . $row['SubjectName'] . '</td>';
        $tableRows .= '<td>' . $row['Professor'] . '</td>';
        $tableRows .= '<td>' . $row['Title'] . '</td>';
        $tableRows .= '<td>' . $row['StartDate'] . '</td>';
        $tableRows .= '<td>' . $row['Duration'] . ' Min</td>';
        $tableRows .= '<td><span>';
        if ($row['Status'] == '0') {
            $tableRows .= 'Inactive';
        } elseif ($row['Status'] == '1') {
            $tableRows .= 'Active';
        } elseif ($row['Status'] == '2') {
            $tableRows .= 'New';
        }
        $tableRows .= '</span> </td>';
        
        $tableRows .= '<td><button id="updateExam"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</button>
        <button class="delete examTableActions"><i class="fa-solid fa-trash-can"></i>&nbsp;Delete</button> ';
        $tableRows .= '</tr>';
    }

    // Generate HTML table
    $table = '<table>';
    $table .= '<thead>';
    $table .= '<tr>';
    $table .= '<th></th>';
    $table .= '<th>ID</th>';
    $table .= '<th>Subject</th>';
    $table .= '<th>Professor</th>';
    $table .= '<th>Title</th>';
    $table .= '<th>Start Date</th>';
    $table .= '<th>Duration</th>';
    $table .= '<th>Status</th>';
    $table .= '<th>Actions</th>';
    $table .= '</tr>';
    $table .= '</thead>';
    $table .= '<tbody id="exam-table-body">';
    $table .= $tableRows;
    $table .= '</tbody>';
    $table .= '</table>';

        echo '<div><span style="font-size:1.5rem; border-bottom:3px solid #b9b1e5;">Exams</span></div>';
        echo $table;
    }
?>