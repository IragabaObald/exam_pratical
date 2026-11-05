
<?php
session_start();

$connect = mysqli_connect('localhost', 'root', '', 'lol_sms');

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = "";

if (isset($_POST['send'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = trim($_POST['role']);

    // Prepare SQL query
    $stmt = mysqli_prepare(
        $connect,
        "SELECT username, password, role
         FROM user
         WHERE username = ? AND role = ?"
    );

    if (!$stmt) {
        die("Query preparation failed: " . mysqli_error($connect));
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $role);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row['password'])) {

        // Store session information
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Redirect according to role
        if ($row['role'] === 'Admin') {
            header("Location: home.php");
            exit;
        } elseif ($row['role'] === 'Local user') {
            header("Location: local.php");
            exit;
        } else {
            $error = "Invalid user role.";
        }

    } else {
        $error = "Incorrect username, password, or role.";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<form action="" method="post" id="log">
    <h1>Login Form</h1>

    <label for="username">Username</label><br>
    <input type="text" id="username" name="username"
           placeholder="Enter Username" required>
    <br><br>

    <label for="password">Password</label><br>
    <input type="password" id="password" name="password"
           placeholder="Enter Password" required>
    <br><br>

    <label for="role">Role</label><br>
    <select id="role" name="role" required>
        <option value="">Select Role</option>
        <option value="Admin">Admin</option>
        <option value="Local user">Local user</option>
    </select>
    <br><br>

    <input type="submit" value="Login" name="send">

    <?php if ($error !== ""): ?>
        <p style="color: red;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <p>
        Don't have an account?
        <a href="signup.php">Create account</a>
    </p>
</form>

</body>
</html>
