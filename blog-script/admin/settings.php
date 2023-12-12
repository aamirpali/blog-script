<?php
require_once 'include/header.php';
require_once '../config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is not logged in, redirect to index.php

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Initialize variables to store form data
$websiteName = '';
$description = '';
$keywords = '';
$newsapiKey = '';
$youtubeApiKey = '';
$googleSearchApiKey = '';
$onesignalAppId = '';
$onesignalAppSecret = '';
$recaptcha = '';
$recaptcha_site_key = '';
$recaptcha_secret_key = '';
$updateMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $websiteName = $_POST['website_name'];
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];
    $newsapiKey = $_POST['newsapi_key'];
    $youtubeApiKey = $_POST['youtube_api_key'];
    $googleSearchApiKey = $_POST['google_search_api_key'];
    $onesignalAppId = $_POST['onesignal_app_id'];
    $onesignalAppSecret = $_POST['onesignal_app_secret'];
    $recaptcha = $_POST['recaptcha'];
    $recaptcha_site_key = $_POST['recaptcha_site_key'];
    $recaptcha_secret_key = $_POST['recaptcha_secret_key'];

    // Update settings in the database
    $sql = "UPDATE settings SET
        website_name = '$websiteName',
        description = '$description',
        keywords = '$keywords',
        newsapi_key = '$newsapiKey',
        youtube_api_key = '$youtubeApiKey',
        google_search_api_key = '$googleSearchApiKey',
        onesignal_app_id = '$onesignalAppId',
        onesignal_app_secret = '$onesignalAppSecret',
        recaptcha = '$recaptcha',
        recaptcha_site_key = '$recaptcha_site_key',
        recaptcha_secret_key = '$recaptcha_secret_key'
        WHERE id = 1";

    if ($conn->query($sql) === TRUE) {
        $updateMessage = 'Settings updated successfully.';
    } else {
        $updateMessage = 'Error updating settings: ' . $conn->error;
    }
}

// Retrieve existing settings from the database
$sql = "SELECT * FROM settings WHERE id = 1"; // Assuming you want to retrieve the first row
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $websiteName = $row['website_name'];
    $description = $row['description'];
    $keywords = $row['keywords'];
    $newsapiKey = $row['newsapi_key'];
    $youtubeApiKey = $row['youtube_api_key'];
    $googleSearchApiKey = $row['google_search_api_key'];
    $onesignalAppId = $row['onesignal_app_id'];
    $onesignalAppSecret = $row['onesignal_app_secret'];
    $recaptcha = $row['recaptcha'];
    $recaptcha_site_key = $row['recaptcha_site_key'];
    $recaptcha_secret_key = $row['recaptcha_secret_key'];
}

$conn->close();
?>

<h2>Site Settings</h2>

<?php if ($updateMessage !== '') : ?>
    <div class="alert <?php echo strpos($updateMessage, 'Error') !== false ? 'alert-danger' : 'alert-success'; ?>">
        <?php echo $updateMessage; ?>
    </div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label for="website_name">Website Name</label>
        <input type="text" class="form-control" id="website_name" name="website_name" value="<?php echo $websiteName; ?>">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description"><?php echo $description; ?></textarea>
    </div>
    <div class="form-group">
        <label for="keywords">Keywords</label>
        <textarea class="form-control" id="keywords" name="keywords"><?php echo $keywords; ?></textarea>
    </div>
    <div class="form-group">
        <label for="newsapi_key">NewsAPI Key</label>
        <input type="text" class="form-control" id="newsapi_key" name="newsapi_key" value="<?php echo $newsapiKey; ?>">
    </div>
    <div class="form-group">
        <label for="youtube_api_key">YouTube API Key</label>
        <input type="text" class="form-control" id="youtube_api_key" name="youtube_api_key" value="<?php echo $youtubeApiKey; ?>">
    </div>
    <div class="form-group">
        <label for="google_search_api_key">Google Search API Key</label>
        <input type="text" class="form-control" id="google_search_api_key" name="google_search_api_key" value="<?php echo $googleSearchApiKey; ?>">
    </div>
    <div class="form-group">
        <label for="onesignal_app_id">OneSignal App ID</label>
        <input type="text" class="form-control" id="onesignal_app_id" name="onesignal_app_id" value="<?php echo $onesignalAppId; ?>">
    </div>
    <div class="form-group">
        <label for="onesignal_app_secret">OneSignal App Secret</label>
        <input type="text" class="form-control" id="onesignal_app_secret" name="onesignal_app_secret" value="<?php echo $onesignalAppSecret; ?>">
    </div>
    <div class="form-group">
    <label for="recaptcha">Recaptcha Status</label>
    <select class="form-control" id="recaptcha" name="recaptcha">
        <option value="1" <?php if ($recaptcha == 1) echo 'selected'; ?>>Enable</option>
        <option value="0" <?php if ($recaptcha == 0) echo 'selected'; ?>>Disable</option>
    </select>
</div>
    <div class="form-group">
        <label for="recaptcha_site_key">Recaptcha Site Key</label>
        <input type="text" class="form-control" id="recaptcha_site_key" name="recaptcha_site_key" value="<?php echo $recaptcha_site_key; ?>">
    </div>
    <div class="form-group">
        <label for="recaptcha_secret_key">Recaptcha Secret key</label>
        <input type="text" class="form-control" id="recaptcha_secret_key" name="recaptcha_secret_key" value="<?php echo $recaptcha_secret_key; ?>">
    </div>
    <button type="submit" class="btn btn-primary">Update Settings</button>
</form>

<?php include 'include/footer.php'; ?>
