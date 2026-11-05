    
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Class Form</title>
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
          <h4 class="card-title mb-0">Add New Class</h4>
        </div>
 <a href="classview.php"><button type="view" class="btn btn-outline-secondary">View</button></a>

        <div class="card-body">
          <form action="" method="POST">
            
            <!-- Class Name Input -->
            <div class="mb-3">
              <label for="class_name" class="form-label">Class Name</label>
              <input type="text" class="form-control" id="class_name" name="class_name" placeholder="ICT"required>
            </div>

            <!-- Academic Year Input -->
            <div class="mb-3">
              <label for="academic_year" class="form-label">Academic Year</label>
              <input type="text" class="form-control" id="academic_year" name="academic_year" placeholder="e.g. 2026-2027" required>
            </div>

            <!-- Form Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <button type="reset" class="btn btn-outline-secondary">Reset</button>
             
              <button type="submit" class="btn btn-primary" name="addclass">Save Class</button>
            </div>
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
    <?php
    if (isset($_POST['addclass'])) {
        $class = $_POST['class_name'];
        $academic =$_POST['academic_year'];
     
        $sql = "INSERT INTO classes VALUES ('', '$class', '$academic')";
        $stat = mysqli_query($connect, $sql);
        
        if ($stat) {
            echo "Class added successfully!";
        } else {
            echo "Error: ";
        }
    }
    ?>
  
</body>
</html>