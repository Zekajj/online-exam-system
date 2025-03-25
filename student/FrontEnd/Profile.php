<?php
@include '../../config.php';

session_start();

if (!isset($_SESSION['studentUsername'])) {
  header('Location:../../login.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="Profile.css" media="all" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body style="background:#f1f1f3;">
  <?php @include 'studentNavbar.php' ?>
  <?php require '../Backend/ManageProfile/StudentProfileLogic.php'; ?>

  <main>
    <section class="user-profile col-4">

      <div class="user-details">
        <?php while ($students = mysqli_fetch_array($Students)) {
        ?>
          <h1><?php echo $students['studentName'] ?></h1>
          <p><?php echo $students['Email'] ?></p>
          <button class="edit-profile" onclick="toggleEditProfile()">Edit Profile</button>
        <?php } ?>
      </div>
      <?php $userData = mysqli_fetch_array($studenti); ?>
      <form class="EditProfile" action="../Backend/ManageProfile/EditStudentProfileLogic.php" style="display:none;" method="post">
        <label>First Name</label>
        <input type="text" name="first_name" value="<?php echo $userData['FirstName']; ?>" placeholder="First Name" class="form-control" />
        <label>Last Name</label>
        <input type="text" name="last_name" value="<?php echo $userData['LastName']; ?>" placeholder="Last Name" class="form-control" />
        <label>Email</label>
        <input type="email" name="email" placeholder="Email" value="<?php echo $userData['Email']; ?>" class="form-control" />
        <label>Username</label>
        <input type="text" name="username" placeholder="Username" value="<?php echo $userData['Username']; ?>" class="form-control" />
        <button type="submit" name="editProfileBtn">Save changes</button>
      </form>
    </section>

    <section class="exam-history col-8">
      <div class="Position">
        <button class="overview" onclick="showExamHistory()"><i class="bi bi-book"></i>&nbsp;Overview</button>
        <button class="change-password" onclick="showChangePassword()"><i class="bi bi-key"></i>&nbsp;Change Password</button>
      </div>
      <div class="ExamHistory">
        <h2>Exam History</h2>
        <?php if (mysqli_num_rows($ExamHistory) == 0) { ?>
          <span class="text-danger">No results</span>
        <?php }
        if (mysqli_num_rows($ExamHistory) > 0) {
        ?>
          <table>
            <thead>
              <tr>
                <th>Exam Name</th>
                <th>Date Started</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($Exams = mysqli_fetch_array($ExamHistory)) {
              ?>
                <tr>
                  <td><?php echo $Exams['Title'] ?></td>
                  <td><?php echo $Exams['StartDate'] ?></td>
                  <td><a href="Results.php">View Results</a></td>
                </tr>
            <?php }
            } ?>

            </tbody>
          </table>
      </div>
      <section class="ChangePassword" style="display:none;">
        <form action="../Backend/ManageProfile/ChangePassword.php" method="POST">
          <input type="text" hidden name="usernameChangePassword" value="<?php echo $userData['Username']; ?>">
          <label>Current Password</label>
          <input type="password" name="currentPassword" placeholder="Current Password" class="form-control" />
          <label>New Password</label>
          <input type="password" name="newPassword" placeholder="New Password" class="form-control" />
          <label>Confirm New Password</label>
          <input type="password" name="confirmPassword" placeholder="Confirm New Password" class="form-control" />
          <button type="submit" name="ChangePasswordBtn">Change Password</button>
        </form>
      </section>
    </section>
  </main>
</body>

<script>
  $(document).ready(function() {
    $('nav .logo-container ul li a.dashboard').removeClass('active');
    $('nav .logo-container ul li a.results').removeClass('active');
    $('nav .logo-container ul li a.profile').addClass('active');
  })
  const overviewBtn = document.querySelector('.overview');
  const passwordBtn = document.querySelector('.change-password');

  overviewBtn.classList.add('active');

  overviewBtn.addEventListener('click', () => {
    overviewBtn.classList.add('active');
    passwordBtn.classList.remove('active');
  });

  passwordBtn.addEventListener('click', () => {
    passwordBtn.classList.add('active');
    overviewBtn.classList.remove('active');
  });

  const editProfileButton = document.querySelector('.edit-profile');
  const editProfileSection = document.querySelector('.EditProfile');

  editProfileButton.addEventListener('click', () => {
    if (editProfileSection.style.display === 'none') {
      editProfileSection.style.display = 'flex';
    } else {
      editProfileSection.style.display = 'none';
    }
  });

  function showExamHistory() {
    document.querySelector(".ExamHistory").style.display = "block";
    document.querySelector(".ChangePassword").style.display = "none";
  }

  function showChangePassword() {
    document.querySelector(".ExamHistory").style.display = "none";
    document.querySelector(".ChangePassword").style.display = "block";
  }
</script>

</html>