<?php
include 'include/header.php'; 
require_once '../config.php'; 
session_start();

if (!isset($_SESSION['admin_username'])) {
    // Redirect to the login page or perform other actions for unauthenticated users.
    header('Location: index.php');
    exit();
}
?>

<div class="container mt-5">
    <h2>Admin Dashboard</h2>
    <p>Welcome to the admin panel.</p>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

</body>
</html>
