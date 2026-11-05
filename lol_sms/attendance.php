<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance </title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <?php
    $connect = mysqli_connect('localhost', 'root', '', 'lol_sms');
    if ($connect) {
        //echo "Connection failed";
    }
    ?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
      
      <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
          <h4 class="card-title mb-0 fs-5 fw-bold">
            <i class="bi bi-journal-check me-2"></i>Student Attendance
          </h4>
          <a href="viewattendance.php"> <button type="reset" class="btn btn-outline-secondary px-4">View Attendance</button></a>
        </div>
        
        <div class="card-body p-4">
          <form action="" method="POST">
            
            <!-- Student Selection -->
            <div class="mb-3">
              <label for="student_id" class="form-label fw-semibold">Select Student</label>
              <select class="form-select" id="student_id" name="student_id" required>
                <?php
                $sql=mysqli_query($connect,"SELECT * FROM students");
                while($data=mysqli_fetch_assoc($sql)){
                  ?>
                
                <option value="" selected hidden>Choose a student...</option>
                <option value="<?php echo $data['student_id'];?>"><?php echo $data['names'];?></option>
            <?php
                }
                ?>
                            </select>
            </div>

            <!-- Subject Selection -->
        
              <div class="col-md-6">
                <label for="academic_year" class="form-label fw-semibold">Date</label>
                <input type="date" class="form-control" id="academic_year" name="date"required>
              </div>
            </div>

            <!-- Marks Input -->
            <div class="mb-4">
              <label for="marks" class="form-label fw-semibold">Attendance Status</label>
        
              <select class="form-select" id="att" name="attendance_status" required>
               
                
                <option value="" selected hidden>Choose a student...</option>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
                    </select>
              
            </div>

            <!-- Form Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <button type="reset" class="btn btn-outline-secondary px-4">Reset</button>
              <button type="submit" class="btn btn-primary px-4" name="addattendance">
                <i class="bi bi-save me-1"></i> Attend
              </button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>
 <?php
    if (isset($_POST['addattendance'])) {
        $student_id = $_POST['student_id'];
        $date = $_POST['date'];
        $attendance =$_POST['attendance_status'];
                 
        $sql = "INSERT INTO attendance VALUES ('', '$student_id', '$date', '$attendance')";
        $stat = mysqli_query($connect, $sql);
        
        if ($stat) {
            echo " successfully!";
        } else {
            echo "Error: ";
        }
    }
    ?>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>