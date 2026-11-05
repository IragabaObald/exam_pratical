<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    session_start();
        $connect = mysqli_connect('localhost', 'root', '', 'lol_sms');
    if ($connect) {
        //echo "Connection failed";
    }
    ?>
        
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php
    $connect = mysqli_connect('localhost', 'root', '', 'lol_sms');
    if ($connect) {
        //echo "Connection failed";
    }
    ?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
         <h1>login form</h1>
        </div>


        <div class="card-body">
          <form action="" method="POST">
            
            <!-- Class Name Input -->
            <div class="mb-3">
              <label for="class_name" class="form-label">UserName</label>
              <input type="text" class="form-control" id="class_name" name="username" placeholder=""required>
            </div>

            <!-- Academic Year Input -->
            <div class="mb-3">
              <label for="academic_year" class="form-label">password</label>
              <input type="password" class="form-control" id="academic_year" name="password" placeholder="" required>
            </div>

            <!-- Form Buttons -->
            <div class="d-flex justify-content-end gap-2">
                        
              <button type="submit" class="btn btn-primary" name="login">Login</button>
            </div>
               <?php
   
   if (isset($_POST['login'])) {
    $a=$_POST['username'];
    $b=$_POST['password'];
    $c=$_POST['role'];
    $insert=mysqli_query($connect,"SELECT * FROM users WHERE username='$a' AND password='$b' AND role='Admin'");

    $log=mysqli_num_rows($insert);
    if ($log==true) {
        $_SESSION['username']=$a;
        header("location:home.php");
    }

   }
   ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


  
</body>
</html>
