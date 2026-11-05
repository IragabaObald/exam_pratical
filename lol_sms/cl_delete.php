          <?php
    $connect = mysqli_connect('localhost', 'root', '', 'lol_sms');
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
   <?php
$id=$_GET['del'];
$del=mysqli_query($connect,"DELETE FROM classes WHERE class_id='$id'");
if ($del) {
    header("location:classview.php");
}
?>