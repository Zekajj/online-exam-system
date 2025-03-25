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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="exam.css">
    <link rel="stylesheet" href="professorDashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Exams</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body  style="background:#f1f1f3;">
    <?php @include 'navbar.php' ?>
    <?php  require '../Backend/ManageResults/ResultsTable.php'?>

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
               <div>
                
               </div>

        </div>

        <div class="examOverview" style="flex-wrap:wrap;">
        <div class="examResults">
            <div class="examName">
                <form method="POST">
                <select id="examSelect" name="examId">
                    <?php $selectExam = "SELECT Id AS ExamId, Title AS ExamName, Duration as ExamDuration from exam";?>

                    <?php $selectExamResult = mysqli_query($conn, $selectExam);
                            if(mysqli_num_rows($selectExamResult) > 0){
                                while($selectExamRow = mysqli_fetch_assoc($selectExamResult)){
                                $selected = ($selectExamRow['ExamId'] == $_POST['examId']) ? 'selected' : '';
                        ?>
                        <option class="exam" <?php echo $selected ?> value="<?php echo $selectExamRow['ExamId'] ?>">
                            <?php echo $selectExamRow['ExamName'] ?>
                        </option>
                        <?php 
                                }
                            }
                        ?>
                </select>
                <button type="submit" style="color:white; background:#e96d7f; padding:5px 20px; border-radius:5px;border:none; " name="submitResultsBtn">Show Results</button>
                </form>
        
            </div>  
            <div class="">
                <label><i class="fa-regular fa-clock"></i>&nbsp;<?php
                    if(isset($_POST['submitResultsBtn'])){
                    $sql = "Select Duration as ExamDuration from exam where Id = $examId";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)>0){
                        $row = mysqli_fetch_array($result);
                        echo $row['ExamDuration'];
                    }
                }
                ?> Min</label>
            </div>
            <?php if(!empty($examId)){ ?>
        </div>
        <div class="examCards">
        <a href="#" class=""><div>
            <i class="fa-solid fa-user-graduate" style="color:#f7b092;"></i>&nbsp;
            <div class="col-auto">
            <span>Total Students</span>
            <h5><?php
                    $sql = "Select Count(*) as StudentCount from users where UserType='1'";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)>0){
                        $row = mysqli_fetch_array($result);
                        echo $row['StudentCount'];
                    }
                ?></h5>
            </div>  
        </div>
        </a>
        
        <a href="#" class=""><div>
        <i class="fa-solid fa-check" style="color:#53b7ec;"></i>&nbsp;
            <div class="col-auto"><span>Joined Students</span>
            <h5><?php
                    $sql = "Select Count(Distinct Student) as JoinedStudents from studentexam where ExamId = $examId";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)>0){
                        $row = mysqli_fetch_array($result);
                        echo $row['JoinedStudents'];
                    }
            
            ?></h5></div>
            
        </div>
        </a>
        <a href="#" class="">
            <div>
            <i class="fa-solid fa-font-awesome" style="color:#93ccad;"></i>&nbsp;
            <div class="col-auto"><span>Total Passed Students</span>
            <h5>
            <?php
                $sql = "SELECT COUNT(*) as PassedStudents FROM (
                    SELECT se.Student
                    FROM studentexam se
                    JOIN studentquestions sq ON sq.StudentExamId = se.Id
                    JOIN studentanswers sa ON sa.StudentQuestionId = sq.Id
                    WHERE se.ExamId = $examId
                        AND sa.Status = '1'
                        AND sa.SelectedAnswer = '1'
                    GROUP BY se.Student
                    HAVING SUM(sq.Points) / " . ($maxRow !== null ? "'{$maxRow['MaxPoints']}'" : "NULL") . " * 100 >= 50
                ) AS Passed";
            
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result)> 0) {
                $row = mysqli_fetch_array($result);
            
                if ($row['PassedStudents'] !== null) {
                    echo $row['PassedStudents'];
                } else {
                    echo 'No results at the moment';
                }
            } else {
                echo 'No results at the moment';
            }     
                ?>
            </h5></div>    
            </div>
        </a>
        <a href="#" class="">
            <div>
            <i class="fa-solid fa-circle-xmark" style="color:#e96d7f;"></i>&nbsp;
            <div class="col-auto"><span>Total Failed Students</span>
            <h5><?php
                $sql = "SELECT COUNT(*) as FailedStudents FROM (
                    SELECT se.Student
                    FROM studentexam se
                    JOIN studentquestions sq ON sq.StudentExamId = se.Id
                    JOIN studentanswers sa ON sa.StudentQuestionId = sq.Id
                    WHERE se.ExamId = $examId
                        AND sa.Status = '1'
                        AND sa.SelectedAnswer = '1'
                    GROUP BY se.Student
                    HAVING SUM(sq.Points) / ". ($maxRow !== null ? "'{$maxRow['MaxPoints']}'" : "NULL") . " * 100 < 50
                ) AS Passed";
                    
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result)> 0) {
                $row = mysqli_fetch_array($result);
            
                if ($row['FailedStudents'] !== null) {
                    echo $row['FailedStudents'];
                } else {
                    echo 'No results at the moment';
                }
            } else {
                echo 'No results at the moment';
            } 
                 ?></h5></div>    
            </div>
        </a>
        <a href="#" class=""><div>
        <i class="fa-solid fa-circle-exclamation" style="color:#b9b1e5;"></i> &nbsp;
            <div class="col-auto"><span>Absent Students</span>
            <h5>
            <?php
                $countJoinedStudents = "Select Count(Distinct Student) as JoinedStudents from studentexam where ExamId = $examId";
                $countJoinedStudentsResult = mysqli_query($conn,$countJoinedStudents);
                $joinedStudents = mysqli_fetch_array($countJoinedStudentsResult);
                $countAllStudents = "Select Count(*) as StudentCount from users where UserType='1'";
                $countAllStudentsResult = mysqli_query($conn,$countAllStudents);
                $allStudents = mysqli_fetch_array($countAllStudentsResult);

                echo $allStudents['StudentCount'] - $joinedStudents['JoinedStudents'];
                
            ?>
            </h5></div>
            
        </div>
        </a>
        <a href="#" class=""><div>
        <i class="fa-solid fa-chart-simple" style="color:#a3abb6;"></i>&nbsp;
            <div class="col-auto"><span>Average Score</span>
            <h5 class="avarageScore"></h5></div>
        </div>
        </a>
        </div>
    </div>


    <div class="filters">
        <div><input type="search" placeholder="Search student" /></div>
        <div>
            <select>
                <option>All</option>
            </select>
            <button>
                Filter&nbsp;<i class="bi bi-filter"></i>
            </button>
        </div>
    </div>

    <div class="studentResultTable">
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Student Name</th>
                    <th>Passed/Failed</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $selectResults = mysqli_query($conn, $selectResultsTable);
                    while ($selectRow = mysqli_fetch_array($selectResults)) {
                    $score = "SELECT SUM(Points) as Score
                              FROM studentquestions sq
                              JOIN studentexam se ON sq.StudentExamId = se.Id 
                              JOIN studentanswers sa ON sa.StudentQuestionId = sq.Id
                              WHERE se.Id = '{$selectRow['StudentExamId']}' AND sa.Status = '1' AND sa.SelectedAnswer = '1'
                              group by se.Student";
                
                    $scoreResult = mysqli_query($conn, $score);
                    $scoreRow = mysqli_fetch_array($scoreResult);
                 ?>
                <tr>
                    <td><?php echo $selectRow['StudentId'] ?></td>
                    <td><?php echo $selectRow['StudentName'] ?></td>
                    <td><span><?php if(number_format(($scoreRow['Score'] / $maxRow['MaxPoints']) * 100,2) >= 50){
                            echo "Passed"; 
                        }
                    else{echo "Failed"; 
                    } ?></span> </td>
                    <td class="scoresTd"><?php echo number_format(($scoreRow['Score'] / $maxRow['MaxPoints']) * 100,2) ?>%</td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
    <?php }?>
</section>


<script>
    $(document).ready(function() {
            $('nav .logo-container ul li a.dashboard').removeClass('active');
            $('nav .logo-container ul li a.exams').removeClass('active');
            $('nav .logo-container ul li a.subjects').removeClass('active');
            $('nav .logo-container ul li a.students').removeClass('active');
            $('nav .logo-container ul li a.results').addClass('active');
            $('nav .logo-container ul li a.profile').removeClass('active');
    })

    $(document).ready(function(){
  var sum = 0;
  var scoreTdCount = $('.scoresTd').length;
  
  $('.scoresTd').each(function() {
    var scoreTdContent = $(this).html();
    var score = parseFloat(scoreTdContent.replace('%',''));
    if (!isNaN(score)) {
      sum += score;
    }
  });

  var averageScore = (sum / scoreTdCount).toFixed(2);
  $('.avarageScore').html(averageScore + '%');
});


const studentResultTableTdList = document.querySelectorAll('.studentResultTable table tbody tr td span');
        studentResultTableTdList.forEach((td) => {
        td.style.border = '1px solid #53b7ec';
        if (td.textContent === 'Failed') {
        td.style.backgroundColor = '#fbe2e5';
        td.style.color = '#e96d7f';
        td.style.border = '1px solid #e96d7f';
        }else if (td.textContent === 'Passed') {
        td.style.backgroundColor = '#d5f6de';
        td.style.color = '#2ed15a';
        td.style.border = '1px solid #2ed15a';
        }
    })




</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
</body>
</html>