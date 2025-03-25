<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body style="background: #f1f1f3;">
    
<style>
    *{
        font-family: 'Poppins', sans-serif;
    }
    .activatedAccountContainer{
        position:absolute;
        left:50%;
        top:50%;
        transform: translate(-50%,-50%);
        width: 600px;
        height: 500px;
        border-radius:5px;
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
        padding:20px 0;
    }
    a{
        border-radius:5px;
        background:#111965;
        color:white;
        padding:15px 30px;
        text-decoration: none;
        margin-top:40px;
    }
</style>

<?php 
    @include 'config.php';
    $_GET['id'];
    $_GET['verificationCode'];

    
    $sql = "select * from users where id='{$_GET['id']}' and verificationCode='{$_GET['verificationCode']}'";

    $updateStatus = "update users set verificationStatus='1' where verificationCode='{$_GET['verificationCode']}' and id='{$_GET['id']}'";


    $result = mysqli_query($conn,$sql);
    mysqli_query($conn,$updateStatus);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_array($result);
    }
    
?>
    <div class="activatedAccountContainer" style="background:white; display:flex; flex-direction:column; align-items:center;">
        <div style="display:flex;flex-direction:column; align-items:center;">
            <h2>Account Activated</h2>
            <i class="fa-solid fa-envelope-circle-check" style="font-size:80px;margin-top: 10px;color:#111965;"></i>

            <b style="margin-top: 40px;margin-right: 12px;">Hello <?php echo $row['FirstName'] ?>,</b>

            <p style="margin-top: 50px;">Thank you, your email has been verified. Your account is now active</p>
            <p style="margin:0;">Please use the link below to login to your account</p>

            <a href="login.php">Log in to your account</a>
        </div>


    </div>






</body>
</html>