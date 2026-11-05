
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Registration</title>
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
        <h2 class="text-success text-center mb-4">Sales Registration Form</h2>

        <form action="#" method="get">
            <div class="mb-3">
                <label for="sale_company" class="form-label">Sale Company</label>
                <input type="text" class="form-control" id="sale_company"
                       name="sale_company" placeholder="Enter company name" required>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity"
                       name="quantity" min="1" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date"
                       name="date" required>
            </div>

            <div class="mb-4">
                <label for="fruit_id" class="form-label">Fruit ID</label>
                <input type="number" class="form-control" id="fruit_id"
                       name="fruit_id" min="1" required>
            </div>

            <button type="submit" class="btn btn-success">Save Sale</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
            <a href="fruit.php" class="btn btn-primary">+ Add Fruit</a>
            <a href="viewsale.html" class="btn btn-dark">View Sales</a>
        </form>
    </div>
</div>

</body>
</html>
