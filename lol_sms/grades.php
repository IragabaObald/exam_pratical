<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Grade Entry</title>
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
            <i class="bi bi-journal-check me-2"></i>Record Student Grade
          </h4>
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
            <div class="mb-3">
              <label for="subject_id" class="form-label fw-semibold">Subject</label>
              <select class="form-select" id="subject_id" name="subject_id" required>
                <?php
                $sql=mysqli_query($connect,"SELECT * FROM subjects");
                while($data=mysqli_fetch_assoc($sql)){
                  ?>
                
                <option value="" selected hidden>Choose a subject...</option>
                <option value="<?php echo $data['subject_id'];?>"><?php echo $data['subject_name'];?>-<?php echo $data['subject_code'];?></option>
            <?php
                }
                ?>
              </select>
            </div>

            <!-- Assessment Type & Academic Year (Grid Row) -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="assessment_type" class="form-label fw-semibold">Assessment Type</label>
                <select class="form-select" id="assessment_type" name="assessment_type" required>
                  <option value="" selected disabled>Select type...</option>
                  <option value="Assignment">Assignment</option>
                  <option value="Final-Exam">Final Exam</option>
                  <option value="Practical">Practical Test</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="academic_year" class="form-label fw-semibold">Academic Year</label>
                <input 
                  type="text" 
                  class="form-control" 
                  id="academic_year" 
                  name="academic_year" 
                  placeholder="e.g. 2026-2027" 
                  required
                >
              </div>
            </div>

            <!-- Marks Input -->
            <div class="mb-4">
              <label for="marks" class="form-label fw-semibold">Marks Obtained (%)</label>
              <div class="input-group">
                <input type="number" step="0.01" min="0" max="100" class="form-control" id="marks" name="marks" placeholder="Enter score (0 - 100)" required
                >
                <span class="input-group-text">%</span>
              </div>
            </div>

            <!-- Form Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <button type="reset" class="btn btn-outline-secondary px-4">Reset</button>
              <button type="submit" class="btn btn-primary px-4" name="addGrade">
                <i class="bi bi-save me-1"></i> Save Grade
              </button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>
 <?php
    if (isset($_POST['addGrade'])) {
        $student_id = $_POST['student_id'];
        $subject_id = $_POST['subject_id'];
        $assessment_type =$_POST['assessment_type'];
        $marks =$_POST['marks'];
        $academic_year =$_POST['academic_year'];
     
        $sql = "INSERT INTO grades VALUES ('', '$student_id', '$subject_id', '$assessment_type', '$marks', '$academic_year')";
        $stat = mysqli_query($connect, $sql);
        
        if ($stat) {
            echo "Grade added successfully!";
        } else {
            echo "Error: ";
        }
    }
    ?>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>