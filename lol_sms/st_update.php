
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
        <?php
    $connect = mysqli_connect('localhost', 'root', '', 'lol_sms');
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
    <?php
        $id=$_GET['up'];
        $sele=mysqli_query($connect,"SELECT * FROM students WHERE student_id='$id'");
        $data=mysqli_fetch_array($sele);
            ?>
   <form action="" method="post" id="log">
    <h1>update student info</h1>
      <label for="admission_number">admission_number</label><br>
        <input type="text" name="admission_number" value="<?php echo $data['admission_number'];?>" required><br><br>

        <label for="names">names</label><br>
        <input type="text" name="names" value="<?php echo $data['names'];?>" required><br><br>

        <label for="gender">gender</label><br>
        <select name="gender" id="gender" value="<?php echo $data['genger'];?>"  required>
            <option value="" hidden>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br><br>
        
        <label for="date_of_birth">date_of_birth</label><br>
        <input type="date" name="date_of_birth" value="<?php echo $data['date_of_birth'];?>" required><br><br>

        <label for="class">class</label><br>
        <select name="class" id="class" value="<?php echo $data['class'];?>" required>
            <option value="">Select Class</option>
            <?php
            $class_query = mysqli_query($connect, "SELECT * FROM classes");
            if ($class_query) {
                while ($row = mysqli_fetch_assoc($class_query)) {
                    echo "<option value='" . $row['class_id'] . "'>" . $row['class_name'] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="phone_number">phone_number</label><br>
        <input type="text" name="phone_number" value="<?php echo $data['phone_number'];?>"><br><br>

        <label for="address">address</label><br>
        <input type="text" name="address" value="<?php echo $data['address'];?>"><br><br>

        <button type="submit" name="updatestudent" class="btn-danger btn-sm">Save</button>
   </form> 
   <?php
   if (isset($_POST['updatestudent'])) {
     $admission_number =$_POST['admission_number'];
        $names =$_POST['names'];
        $gender =$_POST['gender'];
        $dob =$_POST['date_of_birth'];
        $class =$_POST['class'];
        $phone_number =$_POST['phone_number'];
        $address =$_POST['address'];
     
        $sql = "UPDATE students SET admission_number='$admission_number', names='$names', gender='$gender', date_of_birth='$dob', class_id='$class', phone_number='$phone_number', address='$address' WHERE student_id='$id'";
         $stat = mysqli_query($connect, $sql);
        
        if ($stat) {
            echo "<p style='color: green;'>Student updated successfully!</p>";
            header("location:student.php");
        } else {
            echo "<p style='color: red;'>Error: " . mysqli_error($connect) . "</p>";
        }
   
   }
   ?>

</body>
</html>
    