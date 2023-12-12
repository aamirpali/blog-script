<?php
session_start(); // Start a PHP session
require_once('../config.php'); // Include your database configuration
require_once('include/header.php'); // Include your header

// Check if the user is already logged in, redirect to dashboard.php
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            $hashedPassword = $user['password'];

            if (password_verify($password, $hashedPassword)) {
                // Password is correct
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Your update logic here if needed

                header("Location: dashboard.php"); // Redirect to the dashboard or another protected page
                exit();
            } else {
                $loginError = "Invalid username or password.";
            }
        } else {
            $loginError = "Invalid username or password.";
        }

        mysqli_stmt_close($stmt);
    } else {
        die("Prepared statement failed: " . mysqli_error($connection));
    }

    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Add your CSS and Bootstrap include here -->
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-container">
                    <h1 class="form-heading">Login</h1>
                    <?php if (isset($loginError)) { ?>
                        <p class="error-message"><?php echo $loginError; ?></p>
                    <?php } ?>
                    <form method="POST">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Login" class="btn btn-primary btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
