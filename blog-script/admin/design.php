<?php
require_once('../config.php'); // Include your database configuration
require_once('include/header.php'); // Include the header template

// Initialize variables for form values and errors
$logoError = $faviconError = "";
$adsCode = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission

    // Initialize a flag to track if any errors occurred
    $errors = false;

    // Process logo change
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $logoName = $_FILES['logo']['name'];
        $logoTmpName = $_FILES['logo']['tmp_name'];
        $logoFileType = $_FILES['logo']['type'];

        // Validate file type (PNG)
        if ($logoFileType !== 'image/png') {
            $logoError = "Please upload a PNG image.";
            $errors = true;
        } else {
            // Move the uploaded file to the desired location (e.g., 'uploads/logo.png')
            $uploadDir = '../uploads/';
            $logoPath = $uploadDir . 'logo.png';
            move_uploaded_file($logoTmpName, $logoPath);
        }
    }

    // Process favicon change
    if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] === UPLOAD_ERR_OK) {
        $faviconName = $_FILES['favicon']['name'];
        $faviconTmpName = $_FILES['favicon']['tmp_name'];
        $faviconFileType = $_FILES['favicon']['type'];

        // Validate file type (PNG or ICO)
        if ($faviconFileType !== 'image/png' && $faviconFileType !== 'image/x-icon') {
            $faviconError = "Please upload a PNG or ICO favicon.";
            $errors = true;
        } else {
            // Move the uploaded file to the desired location (e.g., 'uploads/favicon.png')
            $uploadDir = '../uploads/';
            $faviconPath = $uploadDir . 'favicon.png'; // Rename it as 'favicon.png'
            move_uploaded_file($faviconTmpName, $faviconPath);
        }
    }

    // Process ads code (optional)
    if (isset($_POST['ads_code'])) {
        $adsCode = $_POST['ads_code'];
    }

    // Update the 'design' table in the database with new values if no errors
    if (!$errors) {
        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$connection) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        // Escape variables before using them in SQL queries
        $logoPath = mysqli_real_escape_string($connection, $logoPath);
        $faviconPath = mysqli_real_escape_string($connection, $faviconPath);
        $adsCode = mysqli_real_escape_string($connection, $adsCode);

        // Update the 'design' table
        $updateQuery = "UPDATE design SET logo = '$logoPath', favicon = '$faviconPath', ads_code = '$adsCode' WHERE id = 1";
        $updateResult = mysqli_query($connection, $updateQuery);

        if (!$updateResult) {
            die("Query failed: " . mysqli_error($connection));
        }

        // Close the database connection
        mysqli_close($connection);
    }
}
?>

<div class="container mt-5">
    <h1>Website Design Settings</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="logo">Change Logo (PNG):</label>
            <input type="file" name="logo" id="logo" accept=".png">
            <span class="text-danger"><?php echo $logoError; ?></span>
        </div>
        <div class="form-group">
            <label for="favicon">Change Favicon (PNG/ICO):</label>
            <input type="file" name="favicon" id="favicon" accept=".png,.ico">
            <span class="text-danger"><?php echo $faviconError; ?></span>
        </div>
        <div class="form-group">
            <label for="ads_code">Custom Ads Code (HTML/JavaScript):</label>
            <textarea name="ads_code" id="ads_code" rows="6" class="form-control"><?php echo htmlspecialchars($adsCode); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php
require_once('include/footer.php'); // Include the footer template
?>
