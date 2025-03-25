<?php 
    @include '../../../config.php';

    $answerId = isset($_POST['answerId']) ? $_POST['answerId'] : '';

    $sql = "Delete from answers where Id = '{$answerId}'";

    mysqli_query($conn, $sql);


?>