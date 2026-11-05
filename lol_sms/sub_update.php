
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
        <a href="subject.php">STUDENT FORM</a>
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
        $sele=mysqli_query($connect,"SELECT * FROM subjects WHERE subject_id='$id'");
        $data=mysqli_fetch_array($sele);
            ?>
   <form action="" method="post" id="log">
    <h1>update student info</h1>
      <label for="subject_name">class_name</label><br>
        <input type="text" name="subject_name" value="<?php echo $data['subject_name'];?>" required><br><br>

        <label for="names">ACADEMIC_YEAR</label><br>
        <input type="text" name="subject_code" value="<?php echo $data['subject_code'];?>" required><br><br>

            <button type="submit" name="updatesubject" class="btn-danger btn-sm">Save</button>
   </form> 
   <?php
   if (isset($_POST['updatesubject'])) {
     $subject_name =$_POST['subject_name'];
        $subject_code =$_POST['subject_code'];
             
        $sql = "UPDATE subjects SET subject_name='$subject_name', subject_code='$subject_code' WHERE subject_id='$id'";
         $stat = mysqli_query($connect, $sql);
        
        if ($stat) {
            echo "<p style='color: green;'>Subject updated successfully!</p>";
            header("location:subjectview.php");
        } else {
            echo "<p style='color: red;'>Error: " . mysqli_error($connect) . "</p>";
        }
   
   }
   ?>

</body>
</html>
    