<?php 
    @include '../../../config.php';

    $examId = isset($_POST['examId']) ? $_POST['examId'] : '';

    $sql = "Delete from exam where Id = '{$examId}'";

    mysqli_query($conn, $sql);

?>