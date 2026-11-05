
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fruit Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.html">Fruit Management</a>
        <div class="navbar-nav flex-row">
            <a class="nav-link mx-2" href="home.html">HOME</a>
            <a class="nav-link mx-2" href="fruit.php">CROPS</a>
            <a class="nav-link mx-2" href="sale.php">SALES</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card shadow p-4 mx-auto mt-5" style="max-width:600px">
        <h2 class="text-success text-center mb-4">Fruit Registration Form</h2>
<?php
    $connect = mysqli_connect('localhost', 'root', '', 'lol_sms');
    if ($connect) {
        echo "Connection failed";
    }
    ?>
    <?php
    
    ?>
        <form action="#" method="POST">
            <div class="mb-3">
                <label for="fruitname" class="form-label">Fruit Name</label>
                <input type="text" class="form-control" id="fruitname"
                       name="fruitname" placeholder="Enter fruit name" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price (Frw)</label>
                <input type="number" class="form-control" id="price"
                       name="price" min="0" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="">Select status</option>
                    <option>Available</option>
                    <option>Unavailable</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date"
                       name="date" required>
            </div>

            <button type="submit" class="btn btn-success" name="addfruit">Save Fruit</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
            <a href="viewfruit.php" class="btn btn-primary">View Fruits</a>
        </form>
    </div>
</div>
  <?php
    $connect = mysqli_connect('localhost', 'root', '', 'lol_sms');
    if ($connect) {
        echo "Connection failed";
    }
    ?>
<?php
    if (isset($_POST['addfruit'])) {
        $fruitname = $_POST['fruitname'];
        $price = $_POST['price'];
        $status =$_POST['status'];
        $date =$_POST['date'];
     
        $sql = "INSERT INTO fruit VALUES ('', '$fruitname', '$price', '$status','$date')";
        $stat = mysqli_query($connect, $sql);
        
        if ($stat) {
            echo "Fruit added successfully!";
        } else {
            echo "Error: ";
        }
    }
    ?>
</body>
</html>
