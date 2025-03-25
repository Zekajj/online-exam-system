<?php 
    @include '../../../config.php';

    $questionId = isset($_POST['questionId']) ? $_POST['questionId'] : '';

    $sql = "Delete from questions where Id = '{$questionId}'";

    mysqli_query($conn, $sql);

    ?>
