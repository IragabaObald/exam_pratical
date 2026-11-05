
<?php
$connect = mysqli_connect('localhost', 'root', '', 'lol_sms');

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

if (isset($_POST['create'])) {
    $username = trim($_POST['u_name']);
    $password = $_POST['u_password'];
    $role = $_POST['role'];

    if ($username === "" || $password === "") {
        $message = "Please fill in all fields.";
    } elseif (!in_array($role, ['Admin', 'Local user'], true)) {
        $message = "Please select a valid role.";
    } else {
        // Check if username already exists
        $check = mysqli_prepare(
            $connect,
            "SELECT u_name FROM admin WHERE u_name = ?"
        );

        mysqli_stmt_bind_param($check, "s", $username);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {
            $message = "Username already exists. Choose another.";
        } else {
            // Hash the password before saving
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = mysqli_prepare(
                $connect,
                "INSERT INTO admin (u_name, u_password, Admin)
                 VALUES (?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "sss",
                $username,
                $hashedPassword,
                $role
            );

            if (mysqli_stmt_execute($stmt)) {
                header("Location: loginn.php?created=1");
                exit;
            } else {
                $message = "Account creation failed.";
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_stmt_close($check);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<form action="" method="post" id="log">
    <h1>Create Account</h1>

    <label for="u_name">Username</label><br>
    <input type="text" id="u_name" name="u_name"
           placeholder="Enter Username" required>
    <br><br>

    <label for="u_password">Password</label><br>
    <input type="password" id="u_password" name="u_password"
           placeholder="Create Password" required minlength="8">
    <br><br>

    <label for="role">Role</label><br>
    <select id="role" name="role" required>
        <option value="">Select Role</option>
        <option value="Local user">Local user</option>
        <option value="Admin">Admin</option>
    </select>
    <br><br>

    <input type="submit" name="create" value="Create Account">

    <?php if ($message !== ""): ?>
        <p style="color:red;">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <p>Already have an account?
        <a href="login.php">Login here</a>
    </p>
</form>

</body>
</html>
