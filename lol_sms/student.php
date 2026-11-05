<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Form</title>
</head>
<body>
     <div class="link">
        <a href="class.php">CLASS FORM</a>
    
    </div>
    <?php
    $connect = mysqli_connect('localhost', 'root', '', 'lol_sms');
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
    
    <h1>STUDENT FORM</h1>

    <form method="POST" action="" style="margin:0;">
        <label for="admission_number">admission_number</label><br>
        <input type="text" name="admission_number" required><br><br>

        <label for="names">names</label><br>
        <input type="text" name="names" required><br><br>

        <label for="gender">gender</label><br>
        <select name="gender" id="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br><br>
        
        <label for="date_of_birth">date_of_birth</label><br>
        <input type="date" name="date_of_birth" required><br><br>

        <label for="class">class</label><br>
        <select name="class" id="class" required>
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
        <input type="text" name="phone_number"><br><br>

        <label for="address">address</label><br>
        <input type="text" name="address"><br><br>

        <button type="submit" name="addstudent" class="btn-danger btn-sm">Save</button>
    </form>

    <?php
    if (isset($_POST['addstudent'])) {
        $admission_number =$_POST['admission_number'];
        $names =$_POST['names'];
        $gender =$_POST['gender'];
        $dob =$_POST['date_of_birth'];
        $class =$_POST['class'];
        $phone_number =$_POST['phone_number'];
        $address =$_POST['address'];
     
        $sql = "INSERT INTO students VALUES ('','$admission_number', '$names', '$gender', '$dob', '$class', '$phone_number', '$address')";
        $stat = mysqli_query($connect, $sql);
        
        if ($stat) {
            echo "<p style='color: green;'>Student added successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . mysqli_error($connect) . "</p>";
        }
    }
    ?><h2>Student List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Admission Number</th>
                <th>Names</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Class</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th colspan="2">Actions</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $w=1;
            $view_query = mysqli_query($connect, "SELECT s.*, c.class_name FROM students s LEFT JOIN classes c ON s.class_id = c.class_id");
            if ($view_query && mysqli_num_rows($view_query) > 0) {
                while ($row = mysqli_fetch_assoc($view_query)) {
                    ?>             
                  
          <tr>
            <td><?php echo $w++;?></td>
            <td><?php echo $row['admission_number'];?></td>
            <td><?php echo $row['names'];?></td>
            <td><?php echo $row['gender'];?></td>
            <td><?php echo $row['date_of_birth'];?></td>
            <td><?php echo $row['class_name'];?></td>
            <td><?php echo $row['phone_number'];?></td>
            <td><?php echo $row['address'];?></td>
            <td class="update"><center><a class="lin" href="st_update.php?up=<?php echo $row['student_id'];?>">Edit</a></center></td>
            <td class="delete"><center><a class="lin" href="st_delete.php?del=<?php echo $row['student_id'];?>">DELETE</a></center></td>
                
          </tr>
           <?php
                }
            } else {
                echo "<tr><td colspan='8'>No students found.</td></tr>";
            }
            ?>
    
            </table>
</body>
</html>