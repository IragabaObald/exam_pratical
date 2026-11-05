<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Class View - School Management System</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php
    $connect = mysqli_connect('localhost', 'root', '', 'lol_sms');
    if ($connect) {
        //echo "Connection failed";
    }
    ?>


<div class="container py-5">
    <h2 class="text-success mb-4">Class</h2>

    <a href="home.php" class="btn btn-dark mb-3">Home</a>
    <a href="class.php" class="btn btn-success mb-3">Add Class</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                   <th>CLASS ID</th>
                <th>CLASS NAME</th>
                <th>ACADEMIC_YEAR</th>
                <th colspan="2">Actions</th>
                </tr>
            </thead>
            <?php
                $connect = mysqli_connect('localhost', 'root', '', 'lol_sms');
                if ($connect) {
                //echo "Connection failed";
             }
             $a=1;
             $sql=mysqli_query($connect,"SELECT * FROM fruit");
             while ($data=mysqli_fetch_assoc($sql)) {
                ?>
           
            <tbody>
                 <?php
            $w=1;
            $view_query = mysqli_query($connect, "SELECT * FROM classes");
            if ($view_query && mysqli_num_rows($view_query) > 0) {
                while ($row = mysqli_fetch_assoc($view_query)) {
                    ?>             
                  
          <tr>
            <td><?php echo $w++;?></td>
            <td><?php echo $row['class_name'];?></td>
            <td><?php echo $row['academic_year'];?></td>
        
            <td class="update"><center><a class="lin" href="cl_update.php?up=<?php echo $row['class_id'];?>">Edit</a></center></td>
            <td class="delete"><center><a class="lin" href="cl_delete.php?del=<?php echo $row['class_id'];?>">DELETE</a></center></td>
                
          </tr>
           <?php
                }
            } else {
                echo "<tr><td colspan='8'>No students found.</td></tr>";
            }
            ?>
    
            </tbody>
            <?php
          }
            ?>
        </table>
    </div>
</div>

</body>
</html>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>