<?php
require_once('config.php'); // Include your database configuration
require_once('header.php'); // Include your header template
?>

<div class="container">
    <h1>Welcome to Your Dashboard</h1>
    <p>Here, you can manage your account and perform various actions.</p>
    
    <!-- Link/Button to Edit Profile -->
    <a href="edit_profile.php" class="btn btn-primary" style="width: 250px; height: 60px;">Edit Profile</a>
</div>

<?php
require_once('footer.php'); // Include your footer template
?>
