       <?php
    $connect = mysqli_connect('localhost', 'root', '', 'lol_sms');
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
       <?php
$id=$_GET['del'];
$del=mysqli_query($connect,"DELETE FROM students WHERE student_id='$id'");
if ($del) {
    header("location:student.php");
}
?>