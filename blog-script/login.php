<?php
require_once('config.php'); // Include your database configuration
require_once('header.php'); // Include your database configuration

session_start(); // Start a PHP session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $username = mysqli_real_escape_string($connection, $username);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        $hashedPassword = $user['password'];

        if (password_verify($password, $hashedPassword)) {
            // Password is correct
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            function getUserLocation($ip) {
    $apiUrl = "http://ip-api.com/json/$ip";
    $response = file_get_contents($apiUrl);
    
    if ($response) {
        $data = json_decode($response);
        if ($data->status == 'success') {
            // Extract relevant location information
            $city = $data->city;
            $region = $data->regionName;
            $country = $data->country;
            return "$city, $region, $country";
        }
    }
    
    return 'Unknown'; // Default value if location cannot be determined
}
            // Log user details like IP address, location, and browser (update the table accordingly)
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $location = getUserLocation($ipAddress);
            $browser = $_SERVER['HTTP_USER_AGENT'];

            // Update user details in the database
            $updateQuery = "UPDATE users SET ip_address = '$ipAddress', location = '$location', browser = '$browser' WHERE id = " . $user['id'];
            $updateResult = mysqli_query($connection, $updateQuery);

            if (!$updateResult) {
                die("Update failed: " . mysqli_error($connection));
            }

            header("Location: dashboard.php"); // Redirect to the dashboard or another protected page
            exit();
        } else {
            $loginError = "Invalid username or password.";
        }
    } else {
        $loginError = "Invalid username or password.";
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
