<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body>
<?php
  require 'signupLogic.php';
?>

    <div class="container-fluid ps-md-0">
        <div class="row g-0">
          <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
          <div class="col-md-8 col-lg-6">
            <div class="login d-flex align-items-center py-5">
              <div class="container">
                <div class="row">
                  <div class="col-md-9 col-lg-8 mx-auto">
                    <h2 class="text-center login-heading mb-5 fw-bold">Online Exam</h2>
                    <!-- Sign In Form -->
                    <form method="post">
                    <?php 
                        if(isset($error)){
                            foreach($error as $error){
                                echo '<div class="alert alert-danger" role="alert">'
                                    .$error
                                .'</div>';
                            }
                        }
                      ?>
                        <?php if(isset($_SESSION['success'])){ ?>
                              <?php echo '<div class="alert alert-success" role="alert">'
                                    .$_SESSION['success']
                                .'</div>' ?>
                        <?php unset($_SESSION['success']); } ?>
                    
                      <div style="display:flex; flex-direction: row; justify-content: center;gap: 10px;">
                      <div class="form-check col">
                        <input class="form-check-input" required type="radio" value="0" name="userType" id="professor">
                        <label class="form-check-label" for="flexRadioDefault1">
                           Professor
                        </label>
                      </div>
                      <div class="form-check mb-3 col">
                        <input class="form-check-input" required type="radio" value="1" name="userType" id="student">
                        <label class="form-check-label" for="flexRadioDefault2">
                          Student
                        </label>
                      </div>
                    </div>
                    <div style="display:flex; justify-content: space-between;gap:10px;">
                        <div class="col form-floating mb-3">
                            <input type="text" class="form-control" required name="firstName" id="firstName" placeholder="FirstName">
                            <label for="floatingInput">First Name</label>
                        </div>
                        <div class="col form-floating mb-3">
                            <input type="text" class="form-control" required name="lastName" id="lastName" placeholder="LastName">
                            <label for="floatingInput">Last Name</label>
                        </div>
                    </div> 
                    <div class="col form-floating mb-3">
                        <input type="email" class="form-control" required name="emailAddress" id="emailAddress" placeholder="name@example.com">
                        <label for="floatingInput">Email Address</label>
                    </div>
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" required name="username" id="username" placeholder="Username">
                        <label for="floatingInput">Username</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="password" class="form-control" required name="password" id="password" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="password" class="form-control" required name="confirmPassword" id="confirmPassword" placeholder="Password">
                        <label for="floatingPassword">Confirm Password</label>
                      </div>
      
                      <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="rememberPasswordCheck">
                        <label class="form-check-label" for="rememberPasswordCheck">
                          Remember password
                        </label>
                      </div>
      
                      <div class="d-grid">
                        <button class="btn btn-lg btn-login text-uppercase fw-bold mb-2" name="signupBtn" style="background: #1d1b31;color:white" type="submit">Sign up</button>
                        <div class=" mt-3 row d-flex justify-content-between">
                          <a class="small col" href="#" style="color:#1d1b31"></a>
                          <p class="login-heading mb-4 col-auto"><a href="index.php" style="color:#1d1b31">I have an account</a></p>
                        </div>
                      </div>
      
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>
</html>