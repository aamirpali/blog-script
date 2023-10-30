<?php
include 'header.php';
require_once 'config.php';

// Function to verify reCAPTCHA
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
    return json_decode($result)->success;
}

// Initialize $recaptchaEnabled with a default value
$recaptchaEnabled = 0;

// Check settings to determine if reCAPTCHA should be used
$settingsQuery = "SELECT recaptcha, recaptcha_site_key, recaptcha_secret_key FROM settings";
$settingsResult = mysqli_query($conn, $settingsQuery);

if ($settingsResult) {
    $settings = mysqli_fetch_assoc($settingsResult);
    $recaptchaEnabled = $settings['recaptcha'];
    $recaptchaSiteKey = $settings['recaptcha_site_key'];
    $recaptchaSecretKey = $settings['recaptcha_secret_key'];
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $recaptchaResponse = $_POST['g-recaptcha-response']; // reCAPTCHA response

    if ($recaptchaEnabled == 1) {
        // Check reCAPTCHA
        if (verifyRecaptcha($recaptchaSecretKey, $recaptchaResponse)) {
            // Insert feedback into database
            $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "Feedback submitted successfully!";
            } else {
                echo "Error submitting feedback.";
            }
        } else {
            echo "reCAPTCHA verification failed. Please try again.";
        }
    } else {
        // Insert feedback into database without reCAPTCHA
        $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "Feedback submitted successfully!";
        } else {
            echo "Error submitting feedback.";
        }
    }
}
?>
<div class="container mt-5">
    <h2>Contact US</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" required></textarea>
        </div>
        <?php if ($recaptchaEnabled == 1) { ?>
            <!-- Display reCAPTCHA if enabled -->
            <div class="g-recaptcha" data-sitekey="<?php echo $recaptchaSiteKey; ?>"></div>
        <?php } ?>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
