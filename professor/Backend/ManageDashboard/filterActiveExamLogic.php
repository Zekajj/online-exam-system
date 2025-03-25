<?php 
@include('../../../config.php');

$activeExam = isset($_POST["activeExam"]) ? $_POST["activeExam"] : '';
$sql = "SELECT e.Id as examId, s.Name as SubjectName, CONCAT(u.FirstName, ' ', u.LastName) as Professor,  e.Title as examTitle, e.StartDate, e.Duration, e.Status 
FROM exam e join users u on e.Professor = u.Id 
join subject s on e.Subject = s.Id where (e.Title like '%{$activeExam}%' or CONCAT(u.FirstName, ' ', u.LastName) like '%{$activeExam}%'  ) and e.Status = '1'  ";


$result = mysqli_query($conn, $sql);
 


 $tableRows = '';

    if(mysqli_num_rows($result) == 0){
        
        echo '<span class="text-danger">No online students</span>';
    }
    else{
    while($row = mysqli_fetch_array($result)) {
        $tableRows .= '<tr data-id="' . $row['examId'] . '">';
        
        $tableRows .= '<td>' . $row['examId'] . '</td>';
        $tableRows .= '<td>' . $row['examTitle'] . '</td>';
        $tableRows .= '<td>' . $row['SubjectName'] . '</td>';
        $tableRows .= '<td>' . $row['Professor'] . '</td>';
        $tableRows .= '<td>' . $row['StartDate'] . '</td>';
        $tableRows .= '<td>' . $row['Duration'] . '</td>';
        $tableRows .= '<td><span>';
        if ($row['Status'] == '0') {
            $tableRows .= 'Inactive';
        } elseif ($row['Status'] == '1') {
            $tableRows .= 'Active';
        } 
        $tableRows .= '</span> </td>';
        
       
        $tableRows .= '</tr>';
    }

    // Generate HTML table
    $table = '<table class="table">';
    $table .= '<thead>';
    $table .= '<tr>';
    $table .= '<th>ID</th>';
    $table .= '<th>Title</th>';         
    $table .= '<th>Subject</th>';
    $table .= '<th>Professor</th>';
    $table .= '<th>Start Date</th>';
    $table .= '<th>Duration</th>';
    $table .= '<th>Status</th>';
    $table .= '</tr>';
    $table .= '</thead>';
    $table .= '<tbody >';
    $table .= $tableRows;
    $table .= '</tbody>';
    $table .= '</table>';

        
        echo $table;
    }







?>