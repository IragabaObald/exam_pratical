
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="link">
        <a href="student.php">STUDENT FORM</a>
        <a href="student.php">STUDENT FORM</a>
    </div>
        <?php
    $connect = mysqli_connect('localhost', 'root', '', 'lol_sms');
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
    <?php
        $id=$_GET['up'];
        $sele=mysqli_query($connect,"SELECT * FROM classes WHERE class_id='$id'");
        $data=mysqli_fetch_array($sele);
            ?>
   <form action="" method="post" id="log">
    <h1>update student info</h1>
      <label for="class_name">class_name</label><br>
        <input type="text" name="class_name" value="<?php echo $data['class_name'];?>" required><br><br>

        <label for="names">ACADEMIC_YEAR</label><br>
        <input type="text" name="academic_year" value="<?php echo $data['academic_year'];?>" required><br><br>

            <button type="submit" name="updateclass" class="btn-danger btn-sm">Save</button>
   </form> 
   <?php
   if (isset($_POST['updateclass'])) {
     $class_name =$_POST['class_name'];
        $class_code =$_POST['academic_year'];
             
        $sql = "UPDATE classes SET class_name='$class_name', academic_year='$class_code' WHERE class_id='$id'";
         $stat = mysqli_query($connect, $sql);
        
        if ($stat) {
            echo "<p style='color: green;'>class updated successfully!</p>";
            header("location:classview.php");
        } else {
            echo "<p style='color: red;'>Error: " . mysqli_error($connect) . "</p>";
        }
   
   }
   ?>

</body>
</html>
    