    
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
          <h4 class="card-title mb-0">Add New Subject</h4>
        </div>
 <a href="subjectview.php"><button type="view" class="btn btn-outline-secondary">View</button></a>

        <div class="card-body">
          <form action="" method="POST">
            
            <!-- Class Name Input -->
            <div class="mb-3">
              <label for="subject_name" class="form-label">Subject Name</label>
              <input type="text" class="form-control" id="subject_name" name="subject_name" placeholder="php"required>
            </div>

          
            <div class="mb-3">
              <label for="academic_year" class="form-label">Subject code</label>
              <input type="text" class="form-control" id="academic_year" name="subject_code" placeholder="e.g. 2026-2027" required>
            </div>

            <!-- Form Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <button type="reset" class="btn btn-outline-secondary">Reset</button>
             
              <button type="submit" class="btn btn-primary" name="addsubject">Save Subject</button>
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
    if (isset($_POST['addsubject'])) {
        $subject = $_POST['subject_name'];
        $code =$_POST['subject_code'];
     
        $sql = "INSERT INTO subjects VALUES ('', '$subject', '$code')";
        $stat = mysqli_query($connect, $sql);
        
        if ($stat) {
            echo "Subject added successfully!";
        } else {
            echo "Error: ";
        }
    }
    ?>
  
</body>
</html>
    
    <h2>Subject List</h2>
    
</body>
</html>