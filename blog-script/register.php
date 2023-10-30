<?php
require_once('config.php'); // Include your database configuration
require_once('header.php'); // Include your header template

// Move session_start() to the top
session_start(); // Start a PHP session

// Initialize variables
$registrationError = '';
$showRecaptcha = false; // By default, hide reCAPTCHA

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the username or email already exists in the database
    $checkQuery = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $checkResult = mysqli_query($connection, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $registrationError = "Username or email already exists.";
    } else {
        // Hash the password before storing it in the database
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Retrieve 'recaptcha' setting from the database
        $settingsQuery = "SELECT recaptcha, recaptcha_site_key, recaptcha_secret_key FROM settings WHERE id = 1";
        $settingsResult = mysqli_query($connection, $settingsQuery);

        if ($settingsResult && mysqli_num_rows($settingsResult) > 0) {
            $settings = mysqli_fetch_assoc($settingsResult);
            $recaptchaEnabled = $settings['recaptcha'];
            $recaptchaSiteKey = $settings['recaptcha_site_key'];
            $recaptchaSecretKey = $settings['recaptcha_secret_key'];
            
            if ($recaptchaEnabled == 1) {
                $showRecaptcha = true; // Show reCAPTCHA
                $recaptchaResponse = $_POST['g-recaptcha-response']; // reCAPTCHA response

                // Verify reCAPTCHA only when it's enabled
                $recaptchaVerification = verifyRecaptcha($recaptchaSecretKey, $recaptchaResponse);

                if (!$recaptchaVerification) {
                    $registrationError = "reCAPTCHA verification failed. Please try again.";
                    $showRecaptcha = true; // Show reCAPTCHA again on error
                }
            }
        }

        if (empty($registrationError)) {
            $username = mysqli_real_escape_string($connection, $username);
            $email = mysqli_real_escape_string($connection, $email);

            // Insert user details into the 'users' table
            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            $result = mysqli_query($connection, $query);

            if ($result) {
                // Registration successful
                $_SESSION['user_id'] = mysqli_insert_id($connection);
                $_SESSION['username'] = $username;

     // Function to get user location based on IP address using ip-api.com with cURL
function getUserLocation($ip) {
    $apiUrl = "http://ip-api.com/json/$ip";
    
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        return 'Unknown'; // Handle cURL error
    }
    
    curl_close($ch);
    
    $data = json_decode($response);
    
    if ($data->status == 'success') {
        $city = $data->city;
        $region = $data->regionName;
        $country = $data->country;
        return "$city, $region, $country";
    }
    
    return 'Unknown'; // Default value if location cannot be determined
}
       // Log user details like IP address, location, and browser (update the table accordingly)
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $location = getUserLocation($ipAddress);
            $browser = $_SERVER['HTTP_USER_AGENT'];

            // Update user details in the database
            $updateQuery = "UPDATE users SET ip_address = '$ipAddress', location = '$location', browser = '$browser' WHERE id = " . $_SESSION['user_id'];
            $updateResult = mysqli_query($connection, $updateQuery);

            if (!$updateResult) {
                die("Update failed: " . mysqli_error($connection));
            }

            header("Location: dashboard.php"); // Redirect to the dashboard or another protected page
            exit();
        } else {
            $registrationError = "Registration failed. Please try again.";
        }
    }

    mysqli_close($connection);
}
}
function verifyRecaptcha($secretKey, $response) {
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secretKey,
        'response' => $response,
    ];

    $options = [
        'http' => [
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === false) {
        return false; // Failed to contact reCAPTCHA server
    }

    $responseData = json_decode($result);

    return $responseData->success;
}
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="register-container">
                    <h1 class="form-heading">Register</h1>
                    <?php if (!empty($registrationError)) : ?>
                        <p class="error-message"><?php echo $registrationError; ?></p>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <?php if ($showRecaptcha) : ?>
                            <!-- Show reCAPTCHA if enabled in settings -->
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="<?php echo $recaptchaSiteKey; ?>"></div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <input type="submit" value="Register" class="btn btn-primary btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
