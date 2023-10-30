<?php
require_once('config.php'); // Include your database configuration

// Function to get website settings
function getWebsiteSettings() {
    global $connection;
    $query = "SELECT * FROM settings";
    $result = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($result);
}

// Function to get logo and favicon URLs from the design table
function getDesignInfo() {
    global $connection;
    $query = "SELECT * FROM design";
    $result = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($result);
}
// Establish a database connection
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$settings = getWebsiteSettings();
$designInfo = getDesignInfo(); // Get design information
// Start or resume the PHP session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in
    $username = $_SESSION['username'];
  $menu = '<li class="nav-item">Welcome, <b><a href="../user/' . $username . '">' . $username . '</a></b></li> &nbsp;';
      $menu .= '<li class="nav-item"><a href="../contact" class="btn btn-danger">Contact</a></li>';
    $menu .= '&nbsp; <li class="nav-item"><a href="../logout" class="btn btn-danger">Logout</a></li>';
} else {
    // User is not logged in
    $menu = '<li class="nav-item"><a href="../login" class="btn btn-primary">Login</a></li>&nbsp; ';
    $menu .= '<li class="nav-item"><a href="../signup" class="btn btn-success">Register</a></li>';
}

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $settings['website_name']; ?></title>
    <meta name="description" content="<?php echo $settings['description']; ?>">
    <meta name="keywords" content="<?php echo $settings['keywords']; ?>">
    <meta name="google-site-verification" content="FlDzzf-DqbvFvZQRrD9uChP_3VyjK1yiamrW6qWwCCI" />
    <link rel="icon" type="image/x-icon" href="<?php echo $designInfo['favicon']; ?>">
<!-- Include Bootstrap CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="../feed"><img src="<?php echo $designInfo['logo']; ?>" alt="Logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                &nbsp; <?php echo $menu; ?>
            </ul>
        </div>
    </nav>